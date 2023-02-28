<div align="center">
    <img align="center" src="public/images/logo_gray--rounded.png" width="150" />
</div>

<div align="center">
    <h2><em>Bookee</em>. Bus trips scheduling and booking system. [WIP]</h2>
</div>


The aim of this project is to develop a system capable of:
- manual and automated bus trips scheduling;
- managing navigation related tasks (routes and stops handling, routes search, complex and compound routes search);
- providing booking capabilities for the passengers;
- providing smooth passengers checkin experience for drivers;
- maintain carrier related domain (like employees management, payrols private motorpool, accounting etc.)
- ...

## Architecture

Trying to stick to these architectural patterns and tech topics:

&ndash; `hexagonal architecture`

&ndash; `CQRS`

&ndash; `command bus`, `query bus`, `event bus`

&ndash; `DDD`

&ndash; `SOLID`

## Status

- `navigation`: routes / stops management done;
- `scheduling`: manual trips scheduling done;
- `booking`: _in progress_;

## How to run

> Requirements: `docker`, `make`

* Clone bookee locally: `git clone git@gitlab.com:aliaksandr.fa/bookee.git`
* Run `make init`. It will pull/build all necessary containers, run migrations and apply fixtures.


## CLI interface

Currently, app has only simple CLI interface. It contains following commands:

```shell

  bookee:booking:trips:book                  [b:b:t:book] > Booking. Book a trip for a passenger.
  bookee:booking:trips:booked                [b:b:t:booked] > Booking. Shows booked trips for customer.
  bookee:booking:trips:schedule              [b:b:t:schedule] > Booking. Shows schedule for date and route.

  bookee:misc:about                          [b:m:a] > Misc. Print about message.

  bookee:navigation:routes:create            [b:n:r:create] > Navigation. Create new route.
  bookee:navigation:routes:list              [b:n:r:list] > Navigation. Lists available routes.
  bookee:navigation:stops:create             [b:n:s:create] > Navigation. Batch create stops.

  bookee:scheduling:timetables:list          [b:s:t:list] > Scheduling. List timetables for route.
  bookee:scheduling:trips:create             [b:s:t:schedule] > Scheduling. Create a trip.
  bookee:scheduling:trips:show               [b:s:t:show] > Scheduling. Shows schedule for date and route.

```
