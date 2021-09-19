# Description

This project does the transformation and conversion of the HTML Metatrader 5 report. It imports the report, transform data and expose the results as an HTTP call. 

# Installation

## Prerequisites

Before installation you need to install docker and docker compose.

```shell

    $ git clone https://github.com/
    $ cd Metatrader5ReportTransformer && docker-compose up -d

```

# Usage

You need to put the HTML reports in the folder **(folder name here)** and the application automatically will read, transform and make available in the following endpoint [http://localhost:8080/](http://localhost:8080/).

## Data flow

1. command: php console report:import read HTML report, transform data and store it at a data storage
2. expose the database content as an API endpoint
