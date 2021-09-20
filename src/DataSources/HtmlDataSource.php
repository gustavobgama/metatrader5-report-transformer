<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\DataSources;

use Symfony\Component\DomCrawler\Crawler;

class HtmlDataSource implements DataSourceInterface
{
    private Crawler $domCrawler;
    private string $filePath;

    public function __construct(
        Crawler $domCrawler,
        string $filePath
    ) {
        $this->domCrawler = $domCrawler;
        $this->filePath = $filePath;
    }

    public function getPositions(): array
    {
        // TODO: detect automatically the content charset of file
        $fileContent = mb_convert_encoding(file_get_contents($this->filePath), 'UTF-8', 'UTF-16LE');
        $this->domCrawler->addContent($fileContent);
        $fileSignatures = [
            'MetaTrader 5',
            'client terminal',
        ];
        if (!in_array($this->domCrawler->filter("meta[name='generator']")->attr('content'), $fileSignatures)) {
            $this->domCrawler->clear();
            return [];
        }
        $foundTheHeader = false;
        $foundTheFooter = false;
        $headers = [];
        $values = [];
        $this->domCrawler->filter('table tr')->each(function (Crawler $tr) use (&$foundTheHeader, &$foundTheFooter, &$headers, &$values) {
            if ($foundTheFooter) {
                return false;
            } else {
                $foundTheFooter = ($tr->filter('th div b')->count() != 0 && $tr->filter('th div b')->html() == 'Orders');
            }
            if ($foundTheFooter) {
                return false;
            }
            if ($foundTheHeader) {
                $tr->filter('td:not(.hidden)')->each(function (Crawler $td) use (&$headers, &$values) {
                    if ($td->children()->count() != 0) {
                        $headers[] = $td->text();
                    } else {
                        $values[] = $td->text();
                    }
                });
            } else {
                $foundTheHeader = ($tr->filter('th div b')->count() != 0 && $tr->filter('th div b')->html() == 'Positions');
            }
        });
        $headers = $this->prepareHeaders($headers);
        // TODO: improve the condition on line 48 and remove this instruction
        array_pop($values);
        $chunks = array_chunk($values, count($headers));
        foreach ($chunks as $chunk) {
            $positions[] = array_combine($headers, $chunk);
        }
        $this->domCrawler->clear();

        return $positions;
    }

    private function prepareHeaders(array $headers): array
    {
        $unique = array_unique($headers);
        $duplicates = array_diff_assoc($headers, $unique);
        foreach ($duplicates as $index => $headerName) {
            $headers[$index] = "{$headerName}_1";
        }

        return $headers;
    }
}
