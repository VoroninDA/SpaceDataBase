REM ********************************************************************
REM Create the PROFILES table to hold Galaxies.
REM SpaceDB.StarDisc table has a foreign key to this table.
REM SpaceDB.Planet table has a foreign key to this table.
REM SpaceDB.Revolves table has a foreign key to this table.
CREATE TABLE profiles
(  
     profName VARCHAR2(25)
    , passSalt VARCHAR2(30)
    , passwordHash VARCHAR2(40)
    , CONSTRAINT prof_pk
                PRIMARY KEY (profName)
    
    
);

REM ********************************************************************
REM Create the STAR table to hold STAR information for Galaxies.
REM SpaceDB.StarDisc table has a foreign key to this table.
REM SpaceDB.Planet table has a foreign key to this table.
REM SpaceDB.Revolves table has a foreign key to this table.


CREATE TABLE star
    ( solar_system	VARCHAR2(25)
    , heat	NUMBER
        CONSTRAINT  heat_nn NOT NULL 
	, date_discovered	DATE
, profile VARCHAR2(25)
	, distance_from_earth	NUMBER
        CONSTRAINT  distance_from_earth_nn NOT NULL 
	, classification	VARCHAR2(5)
		CONSTRAINT  classification_nn NOT NULL 
    );

ALTER TABLE star
ADD ( CONSTRAINT solar_system_pk
       		 PRIMARY KEY (solar_system, profile)
    );
	
REM ********************************************************************
REM Create the STAR DISCOVERY (StarDisc) table to hold multivariable information where we store stars 
REM the associated pioneer.


CREATE TABLE stardisc 
    ( solar_system	VARCHAR2(25)
    , pioneer	VARCHAR2(40) 
    , CONSTRAINT     star_discovery_pk 
         	     PRIMARY KEY (solar_system, pioneer) 
    );

ALTER TABLE stardisc
ADD ( CONSTRAINT stardisc_fk
        	 FOREIGN KEY (solar_system)
          	  REFERENCES star(solar_system) 
    );
 
REM ********************************************************************
REM Create the PLANET table to hold basic information on a planet.
REM SpaceDB.Revoles table has a foreign key to this table.
REM SpaceDB.PlanetDisc table has a foreign key to this table.
REM SpaceDB.Center table has a foreign key to this table.
REM SpaceDB.Satellite table has a foreign key to this table.

CREATE TABLE planet
    ( name	VARCHAR2(25)
    , solar_system  VARCHAR2(25)
    , distance_from_center  NUMBER
    , mass      NUMBER
	, CONSTRAINT 	planet_pk
				PRIMARY KEY (name)
    ) ;
	
ALTER TABLE planet
ADD ( CONSTRAINT planet_fk
       		 FOREIGN KEY (solar_system)
        	  REFERENCES star (solar_system)
     ) ;

REM ********************************************************************
REM Create the REVOLVES table to hold multivariable information for planets and solar systems.


CREATE TABLE revolves
    ( solar_system	VARCHAR2(25)
    , planet_name	VARCHAR2(25)
	, CONSTRAINT     revolves_pk 
         	     PRIMARY KEY (solar_system, planet_name) 
    ); 
ALTER TABLE revolves
ADD ( CONSTRAINT revolves_fk
        	 FOREIGN KEY (solar_system)
          	  REFERENCES star(solar_system) 
    );
ALTER TABLE revolves
ADD ( CONSTRAINT revolves_fk1
        	 FOREIGN KEY (planet_name)
          	  REFERENCES planet(name) 
    );
    
REM ********************************************************************
REM Create the PLANET DISCOVERY (PlanetDisc) table to hold multivariable information where we store planets. 
REM the associated pioneer.

CREATE TABLE planetdisc 
    ( planet_name	VARCHAR2(25)
    , pioneer	VARCHAR2(40) 
    , CONSTRAINT     planet_discovery_pk 
         	     PRIMARY KEY (planet_name, pioneer) 
    );

ALTER TABLE planetdisc
ADD ( CONSTRAINT planetdisc_fk
        	 FOREIGN KEY (planet_name)
          	  REFERENCES planet(name) 
    );
REM ********************************************************************
REM Create the SATELLITE table to hold the Satellite inventory information.
REM SpaceDB.Center table has a foreign key to this table.
REM ~~~
REM SpaceDB.Artificial and SpaceDB.Moon are types of Satellites.
REM SpaceDB.Artificial table has a foreign key to this table.
REM SpaceDB.Moon table has a foreign key to this table.


CREATE TABLE satellite
    ( id VARCHAR2 (25)
	, orbits VARCHAR2(25)
	, distance_from_center NUMBER
	, classification VARCHAR2 (10)
	, CONSTRAINT satellite_pk
				PRIMARY KEY (id)
    ) ;

ALTER TABLE satellite
ADD ( CONSTRAINT satellite_fk
				FOREIGN KEY (orbits)
				REFERENCES planet(name)
	);

REM ********************************************************************
REM Create the MOON table to hold the Moon specific atribute information.


CREATE TABLE moon
    ( id VARCHAR2 (25)
	, mass number(25)
	, CONSTRAINT moon_pk
				PRIMARY KEY (id)
    ) ;

ALTER TABLE moon
ADD ( CONSTRAINT moon_fk
				FOREIGN KEY (id)
				REFERENCES satellite(id)
	);

REM ********************************************************************
REM Create the MOON table to hold the Moon specific atribute information.


CREATE TABLE artificial
    ( id VARCHAR2 (25)
	, launched_by VARCHAR2(25)
	, date_launched DATE
	, cost NUMBER
	, CONSTRAINT artificial_pk
				PRIMARY KEY (id)
    ) ;

ALTER TABLE artificial
ADD ( CONSTRAINT artificial_fk
				FOREIGN KEY (id)
				REFERENCES satellite(id)
	);

REM ********************************************************************
REM Create the CENTER table to hold the location of satellites.


CREATE TABLE center
    ( planet_name   VARCHAR2(25)
    , sat_id  VARCHAR(25)
	  ,  CONSTRAINT    center_pk
          PRIMARY KEY (planet_name, sat_id)
    );
	
ALTER TABLE center
ADD ( CONSTRAINT center_fk
        	 FOREIGN KEY (planet_name)
          	  REFERENCES planet(name) 
    );
ALTER TABLE center
ADD ( CONSTRAINT center_fk1
        	 FOREIGN KEY (sat_id)
          	  REFERENCES satellite(id) 
    );

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

REM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
REM THIS IS THE PROCEDURES FOR PROFILE ENCRYPT
REM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
create or replace PROCEDURE addProfile (
      newProfName VARCHAR2
    , newPasswordText VARCHAR2
    )
AS
l_salt           profiles.passSalt%type := random32HexGen;
l_hashedPass      profiles.passwordHash%type;
BEGIN

SELECT get_hash_salted(newProfName,newPasswordText, l_Salt)
into l_hashedPass
from dual;

        INSERT INTO profiles (profName, passSalt, passwordHash)
        VALUES(UPPER(newProfName)
        , l_salt
        , l_hashedPass);
            
END;

create or replace PROCEDURE valid_user_p (p_username  IN  VARCHAR2,
                        p_password  IN  VARCHAR2 ,
                        exists_flag OUT CHAR) AS
    p_salt VARCHAR2(32);
  BEGIN
  
    SELECT passSalt
    INTO   p_salt
    FROM   Profiles
    WHERE  profName = UPPER(p_username);
	
	SELECT 'T'
INTO 
exists_flag
FROM profiles
WHERE
    PASSWORDHASH = GET_HASH_SALTED(p_username, p_password, p_salt);
    
  EXCEPTION
    WHEN NO_DATA_FOUND THEN
      RAISE_APPLICATION_ERROR(-20000, 'Invalid username/password.');
  END;

create or replace FUNCTION GET_HASH 
(
  P_profNAME IN VARCHAR2 
, P_PASSWORD IN VARCHAR2 
) RETURN VARCHAR2 AS 
P_salt VARCHAR(32);
BEGIN
  SELECT random32hexgen
  into p_salt
  from dual;
  RETURN DBMS_CRYPTO.HASH(UTL_RAW.CAST_TO_RAW(UPPER(p_profname) || p_SALT || UPPER(p_password)),DBMS_CRYPTO.HASH_SH1);
END GET_HASH;

create or replace FUNCTION GET_HASH_SALTED 
(
  P_profNAME IN VARCHAR2 
, P_PASSWORD IN VARCHAR2 
, p_salt in VARCHAR2
) RETURN VARCHAR2 AS 
BEGIN
  RETURN DBMS_CRYPTO.HASH(UTL_RAW.CAST_TO_RAW(UPPER(p_profname) || p_SALT || UPPER(p_password)),DBMS_CRYPTO.HASH_SH1);
END GET_HASH_SALTED;

create or replace FUNCTION random32HexGen
RETURN VARCHAR2 IS
new_salt VARCHAR2(32);
BEGIN
select regexp_replace(
            to_char(
            DBMS_RANDOM.value(0, power(2, 128)-1),
            'FM0xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
            '([a-f0-9]{8})([a-f0-9]{4})([a-f0-9]{4})([a-f0-9]{4})([a-f0-9]{12})',
            '\1\2\3\4\5')
into new_salt
from dual;
RETURN new_salt;
END;

create or replace FUNCTION valid_user (p_username  IN  VARCHAR2,
                       p_password  IN  VARCHAR2) 
    RETURN CHAR AS
    exists_flag CHAR(1 BYTE);
  BEGIN
    valid_user_p(p_username, p_password, exists_flag);
    RETURN exists_flag;
  EXCEPTION
    WHEN OTHERS THEN
      Select 'F'
      into exists_flag
      from Dual;
      RETURN exists_flag;
  END;