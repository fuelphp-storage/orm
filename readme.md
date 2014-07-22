# FuelPHP Orm library.

[![Build Status](https://travis-ci.org/fuelphp/orm.png?branch=master)](https://travis-ci.org/fuelphp/orm)
[![Code Coverage](https://scrutinizer-ci.com/g/fuelphp/orm/badges/quality-score.png?s=3a071a3f142f3b15c1c0db144b3b8c62fa5662e8)](https://scrutinizer-ci.com/g/fuelphp/orm/)
[![Code Quality](https://scrutinizer-ci.com/g/fuelphp/orm/badges/coverage.png?s=7ead6a412939c54825a917a3bde03f55aba940b8)](https://scrutinizer-ci.com/g/fuelphp/orm/)

V2 orm currently consists of three separate parts that work together to provide a database abstraction via objects.
These parts are `Provider`s, `Query`s and `Model`s. The names of these might change depending on their eventual implementation.

A `Provider` contains the model's properties, table name and other related information. If you are familiar with the v1 orm
this replaces the static properties that used to define the properties, relations, connection, table name and observers.
The providers should (at the moment at least) be the first point of entry for interacting with

`Query` objects provide a way for the developer to perform actions on the database using the abstraction of the ORM.
The idea is that a `Query` object is responsible for talking to whatever database system you are using, be it MySQL,
noSQL or flat text files.

`Model`, unlike v1, are dummy data container objects. The intent is to make them as light as possible to make dealing
with large data sets more efficient. They may contain an interface that passes through to a `Query` or `Provider` in the
future.
