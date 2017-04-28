REM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~`
REM These are views for the SpaceDB
REM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



REM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
REM This view generates the full information given from 
REM the disjoin relation between satellite type artificial.
CREATE VIEW full_artificial_sat     AS 
SELECT    satellite.ID                    AS "Name"
        , satellite.ORBITS                AS "Orbits around"
        , satellite.DISTANCE_FROM_CENTER  AS "Orbital hieght"
        , satellite.CLASSIFICATION        AS "Type of satellite"
        , artificial.LAUNCHED_BY          AS "Who shot me into orbit"
        , artificial.DATE_LAUNCHED        AS "When shot into orbit"
        , artificial.COST                 AS "Dolla Dolla bill yall"
FROM satellite
JOIN artificial ON satellite.id=artificial.ID;



REM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
REM This view generates the full information given from 
REM the disjoin relation between satellite type moon/natural.
CREATE VIEW full_moon_sat           AS 
SELECT    satellite.ID                    AS "Name"
        , satellite.ORBITS                AS "Orbits around"
        , satellite.DISTANCE_FROM_CENTER  AS "Orbital hieght"
        , satellite.CLASSIFICATION        AS "Type of satellite"
        , moon.MASS                       AS "Reported Mass"
FROM satellite
JOIN moon ON satellite.id=moon.ID;