/*
-- Queries: 

DROP TABLE IF EXISTS `eveonline_subsystems`;
CREATE TABLE `eveonline_subsystems` (
  `typeID` int(10) NOT NULL DEFAULT 0,
  `typeName` varchar(255) NOT NULL DEFAULT "",
  `Low` int(2) NOT NULL DEFAULT 0,
  `Medium` int(2) NOT NULL DEFAULT 0,
  `High` int(2) NOT NULL DEFAULT 0,
  `Drone` int(2) NOT NULL DEFAULT 0,
  PRIMARY KEY  (`typeID`)
);

-----

INSERT INTO `eveonline_subsystems` (`typeID`, `typeName`, `Low`, `Medium`, `High`, `Drone`)
SELECT it.typeID, it.typeName, IFNULL(low.valueInt, IFNULL(low.valueFloat,0)) AS Low, IFNULL(med.valueInt, IFNULL(med.valueFloat,0)) AS Medium, IFNULL(high.valueInt, IFNULL(high.valueFloat,0)) AS High, IFNULL(drone.valueInt, IFNULL(drone.valueFloat,0)) AS Drone
FROM invTypes AS it
JOIN invGroups g on it.groupID = g.groupID
JOIN invCategories c ON c.categoryID = g.categoryID
JOIN chrRaces r ON it.raceID = r.raceID
JOIN invMarketGroups mg ON it.marketGroupID = mg.marketGroupID
LEFT JOIN dgmTypeAttributes AS low ON it.typeID = low.typeID AND low.attributeID = 1376
LEFT JOIN dgmTypeAttributes AS med ON it.typeID = med.typeID AND med.attributeID = 1375
LEFT JOIN dgmTypeAttributes AS high ON it.typeID = high.typeID AND high.attributeID = 1374
LEFT JOIN dgmTypeAttributes AS drone ON it.typeID = drone.typeID AND drone.attributeID = 283
WHERE it.published = 1
AND c.categoryId = 32


-----

UPDATE `eveonline_subsystems` SET `Drone` = 4 WHERE `Drone` > 0

-----

Date: 2014-02-11 20:40 - Cyerus
*/
