REM ********************************************************************
REM Create the STAR table to hold STAR information for Galaxies.
REM SpaceDB.StarDisc table has a foreign key to this table.
REM SpaceDB.Planet table has a foreign key to this table.
REM SpaceDB.Revolves table has a foreign key to this table.


CREATE TABLE star
    ( solar_system	VARCHAR2(25)
    , heat	NUMBER
	, date_discovered	DATE
	, distance_from_earth	NUMBER
	, classification	VARCHAR2(5)
		CONSTRAINT  classification_nn NOT NULL 
    );

ALTER TABLE star
ADD ( CONSTRAINT solar_system_pk
       		 PRIMARY KEY (solar_system)
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