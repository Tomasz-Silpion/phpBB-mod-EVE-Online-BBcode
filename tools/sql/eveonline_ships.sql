/*
-- Queries: 

DROP TABLE IF EXISTS `eveonline_ships`;
CREATE TABLE `eveonline_ships` (
  `typeID` int(10) NOT NULL DEFAULT 0,
  `typeName` varchar(255) NOT NULL DEFAULT "",
  `Low` int(2) NOT NULL DEFAULT 0,
  `Medium` int(2) NOT NULL DEFAULT 0,
  `High` int(2) NOT NULL DEFAULT 0,
  `Drone` int(5) NOT NULL DEFAULT 0,
  `Rig` int(2) NOT NULL DEFAULT 0,
  `Subsystem` int(2) NOT NULL DEFAULT 0,
  `raceID` int(2) NOT NULL DEFAULT 0,
  `raceName` varchar(255) NOT NULL DEFAULT "",
  `Tech` varchar(255) NOT NULL DEFAULT "",
  `groupName` varchar(255) NOT NULL,
  `marketGroupName` varchar(255) NOT NULL,
  `Icon` varchar(255) NOT NULL DEFAULT "",
  PRIMARY KEY  (`typeID`)
);

-----

INSERT INTO `eveonline_ships` (`typeID`, `typeName`, `Low`, `Medium`, `High`, `Drone`, `Rig`, `Subsystem`, `raceID`, `raceName`, `Tech`, `groupName`, `marketGroupName`)
SELECT it.typeID, it.typeName, IFNULL(low.valueInt, IFNULL(low.valueFloat,0)) AS Low, IFNULL(med.valueInt, IFNULL(med.valueFloat,0)) AS Medium, IFNULL(high.valueInt, IFNULL(high.valueFloat,0)) AS High, IFNULL(drone.valueInt, IFNULL(drone.valueFloat,0)) AS Drone, IFNULL(rig.valueInt, IFNULL(rig.valueFloat,0)) AS Rig, IFNULL(sub.valueInt, IFNULL(sub.valueFloat,0)) AS Subsystem, it.raceID, r.raceName, IFNULL(tech.valueInt, IFNULL(tech.valueFloat,1)) AS Tech, g.groupName, mg.marketGroupName
FROM invTypes AS it
JOIN invGroups g on it.groupID = g.groupID
JOIN invCategories c ON c.categoryID = g.categoryID
JOIN chrRaces r ON it.raceID = r.raceID
JOIN invMarketGroups mg ON it.marketGroupID = mg.marketGroupID
LEFT JOIN dgmTypeAttributes AS low ON it.typeID = low.typeID AND low.attributeID = 12
LEFT JOIN dgmTypeAttributes AS med ON it.typeID = med.typeID AND med.attributeID = 13
LEFT JOIN dgmTypeAttributes AS high ON it.typeID = high.typeID AND high.attributeID = 14
LEFT JOIN dgmTypeAttributes AS drone ON it.typeID = drone.typeID AND drone.attributeID = 283
LEFT JOIN dgmTypeAttributes AS rig ON it.typeID = rig.typeID AND rig.attributeID = 1137
LEFT JOIN dgmTypeAttributes AS sub ON it.typeID = sub.typeID AND sub.attributeID = 1367
LEFT JOIN dgmTypeAttributes AS tech ON it.typeID = tech.typeID AND tech.attributeID = 422
WHERE it.published = 1
AND c.categoryId = 6

-----

UPDATE `eveonline_ships` SET `Tech` = "Tech III" WHERE `Tech` = "3";
UPDATE `eveonline_ships` SET `Tech` = "Faction" WHERE `marketGroupName` = "Navy Faction" OR `marketGroupName` = "Pirate Faction" OR `marketGroupName` = "Special Frigates" OR `marketGroupName` = "Faction Carrier";
UPDATE `eveonline_ships` SET `Tech` = "Tech II" WHERE `Tech` = "2";
UPDATE `eveonline_ships` SET `Tech` = "Tech I" WHERE `Tech` = "1";

UPDATE `eveonline_ships` SET `Icon` = "Caldari" WHERE `marketGroupName` = "Caldari";
UPDATE `eveonline_ships` SET `Icon` = "Amarr" WHERE `marketGroupName` = "Amarr";
UPDATE `eveonline_ships` SET `Icon` = "Gallente" WHERE `marketGroupName` = "Gallente";
UPDATE `eveonline_ships` SET `Icon` = "Minmatar" WHERE `marketGroupName` = "Minmatar";
UPDATE `eveonline_ships` SET `Icon` = "Jove" WHERE `raceName` = "Jove";
UPDATE `eveonline_ships` SET `Icon` = "ORE" WHERE `marketGroupName` = "ORE";

UPDATE `eveonline_ships` SET `Icon` = "Amarr_Navy" WHERE `raceName` = "Amarr" AND `marketGroupName` = "Navy Faction";
UPDATE `eveonline_ships` SET `Icon` = "Caldari_Navy" WHERE `raceName` = "Caldari" AND `marketGroupName` = "Navy Faction";
UPDATE `eveonline_ships` SET `Icon` = "Gallente_Navy" WHERE `raceName` = "Gallente" AND `marketGroupName` = "Navy Faction";
UPDATE `eveonline_ships` SET `Icon` = "Minmatar_Navy" WHERE `raceName` = "Minmatar" AND `marketGroupName` = "Navy Faction";

UPDATE `eveonline_ships` SET `Icon` = "Guristas" WHERE `typeID` IN (17715, 17918, 17930);   -- Gila, Rattlesnake, Worm
UPDATE `eveonline_ships` SET `Icon` = "Serpentis", `raceName` = "Gallente" WHERE `typeID` IN (17722, 17740, 17928);   -- Vigilant, Vindicator, Daredevil (also fix for Daredevil `raceName`)
UPDATE `eveonline_ships` SET `Icon` = "Angel_Cartel" WHERE `typeID` IN (17720, 17738, 17932);   -- Cynabal, Machariel, Dramiel
UPDATE `eveonline_ships` SET `Icon` = "Blood_Raiders" WHERE `typeID` IN (17920, 17922, 17926);   -- Bhaalgorn, Ashimmu, Cruour
UPDATE `eveonline_ships` SET `Icon` = "Sansha" WHERE `typeID` IN (3514, 3532, 17718, 17736, 17924);   -- Revenant, Echelon, Phantasm, Nightmare, Succubus
UPDATE `eveonline_ships` SET `Icon` = "Gallente" WHERE `typeID` = 2078;   -- Zephyr

UPDATE `eveonline_ships` SET `Drone` = 4 WHERE `Drone` > 0

-----


Date: 2012-06-30 19:22 - Cyerus
*/