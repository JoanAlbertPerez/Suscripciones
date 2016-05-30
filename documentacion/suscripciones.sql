create database suscripcion;

  use suscripcion;

  create table admin (
    id int(24) not null auto_increment,
    nombre varchar(225) not null,
    password varchar(225) not null,
    primary key (id)
  );

  create table usuario  (
    id int(25) not null auto_increment,
    nombre varchar(128) not null,
    apellidos varchar(128) not null,
    estado enum('alta', 'baja') not null,
    dni varchar(9) not null,
    telefono varchar(9) not null,
    fecha_nac date not null,
    ultimo_cobro date,
    primary key (id)
  );

  create table altas_bajas(
    id int(25) not null auto_increment,
    tipo enum('alta', 'baja', 'error') not null,
    mensaje varchar(128),
    usuario_id int(25) not null,
    telefono varchar(9) not null,
    fecha datetime not null,
    primary key (id),
    foreign key (usuario_id) references usuario(id)
  );


  create table cobros(
    id int(25) not null auto_increment,
    tipo enum('si', 'no') not null,
    mensaje varchar(128),
    usuario_id int(25) not null,
    telefono varchar(9) not null,
    fecha datetime CURRENT_TIMESTAMP,
    primary key (id),
    foreign key (usuario_id) references usuario(id)
  );


  create table sms(
    id int(25) not null auto_increment,
    tipo enum('si', 'no') not null,
    mensaje varchar(128),
    usuario_id int(25) not null,
    telefono varchar(9) not null,
    fecha datetime CURRENT_TIMESTAMP,
    primary key (id),
    foreign key (usuario_id) references usuario(id)
  );


  create table web_service(
    id int(25) not null auto_increment,
    tipo enum('pet_token', 'pet_sms', 'pet_cobro') not null,
    stat_code enum('SUCCESS', 'BAD_REQUEST-TYPE', 'NO_REQUEST', 'SYSTEM_ERROR', 'INVALID_XML', 'MISSING_PROPERTY', 'MISSING_CREDENTIALS', 'INVALID_CREDENTIALS', 'TOKEN_SUCCESS', 'TOKEN_ALREADY_USED', 'INVALID_TOKEN', 'NO_FUNDS', 'CHARGING_ERROR', 'DUPLICATED_TR' ) not null,
    stat_msg varchar(128) not null,
    transaction int(255) not null,
    msisdn varchar(9),
    shortcode varchar(3),
    text varchar(255),
    token varchar(255),
    tx_id varchar(25) not null,
    usuario_id int(25) not null,
    fecha datetime CURRENT_TIMESTAMP,
    amount double(10,4),
    primary key (id),
    foreign key (usuario_id) references usuario(id)
  );



INSERT INTO `web_service`(`tipo`, `stat_CODE`, `stat_msg`, `transaction`, `msisdn`, `shortcode`, `text`, `token`, `tx_id`, `usuario_id`) VALUES (['pet-token'],['SUCCESS'],['algo'],[1],['666559977'],['666'],['algo2'],['154613564fsv4s31fv3TOKENagfrfd24a2352af4'],['1'],[1])


INSERT INTO 'admin' VALUES ('admin', 'admin');


INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Ocean","Poole Bell","baja",89052485,"909376994","1956/02/24"),("Karina","Hester Baker","baja",77373597,"620391561","1942/04/27"),("Dorothy","Curry Boyle","baja",74272337,"655175192","1955/03/01"),("Yvette","Craig Daniel","baja",77337439,"679543171","1928/06/26"),("Neil","Burris Wilcox","baja",93425831,"936612381","2012/06/21"),("Caleb","Phelps Valentine","baja",58069920,"924586281","1999/09/15"),("Moana","Morgan Gilliam","baja",98310315,"620771217","1938/02/16"),("Stone","Flores Velazquez","baja",91382807,"993255491","1953/09/05"),("Ignatius","Lynn Mcmahon","baja",65728296,"699639697","1963/07/15"),("Lynn","Kinney Pittman","baja",77809945,"920215592","1994/01/30");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Taylor","Conrad Harrison","baja",68865175,"656987380","1995/07/02"),("Hayley","Horn Morton","baja",96315895,"904699174","1948/08/02"),("Destiny","Hawkins Cline","baja",88083445,"962211378","1984/08/15"),("Galvin","Potts Glass","baja",85106949,"982161512","1952/12/03"),("Aretha","Bush Navarro","baja",82145341,"637861902","1980/10/09"),("Lenore","Pollard Cantrell","baja",85477121,"656343459","1928/04/08"),("Imogene","Greene Bennett","baja",47962039,"669020161","1937/01/18"),("Jermaine","Cherry Davidson","baja",66084632,"626905100","1974/12/13"),("Simone","Mcdonald Nelson","baja",56322454,"958082207","2001/06/18"),("Leonard","Wagner Mann","baja",89053809,"675510083","1936/03/24");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Eleanor","Casey Mckay","baja",61593888,"629140787","1965/08/23"),("Allegra","Shepherd Glenn","baja",94616195,"663885653","1939/10/04"),("Gabriel","Powers Alexander","baja",98840219,"684541162","1982/03/13"),("Germaine","Andrews Vang","baja",50732166,"904691626","1962/06/23"),("Germane","Reynolds Kelley","baja",52009496,"949287283","2010/09/06"),("Kalia","Snyder Dickerson","baja",47841769,"678840004","1953/01/28"),("Angelica","Espinoza Douglas","baja",67070689,"615176322","1932/04/30"),("Maggy","Kaufman Howard","baja",93259102,"908633492","1942/11/14"),("Quintessa","Gonzales Richardson","baja",62431701,"678128872","2000/05/17"),("Adam","Cervantes Beck","baja",87608708,"911523903","1946/03/28");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Fritz","Talley Livingston","baja",60957746,"937454777","1992/06/14"),("Indira","Klein Kennedy","baja",74038165,"634841842","1959/06/12"),("Candace","Bryant Ferguson","baja",63150552,"607642257","1983/12/07"),("Cedric","Fuller Foster","baja",82209367,"617716098","2009/09/12"),("Nathaniel","Holloway Stevenson","baja",73858053,"649113369","1958/10/20"),("Armando","Bullock Mcdonald","baja",71435619,"685287219","2005/05/02"),("Venus","Foreman Hawkins","baja",94305154,"662454382","1956/09/17"),("Hiroko","Simmons Morin","baja",65247562,"681777771","1999/03/09"),("Guy","Parks Tillman","baja",64963954,"651786480","1986/11/24"),("Malik","Roberts Chambers","baja",57111100,"929865120","1960/05/03");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Paula","Roberson Gibbs","baja",97210610,"654724846","1946/03/24"),("Marvin","Watson Huff","baja",53815819,"962144769","1970/08/01"),("Winter","Lyons Wood","baja",73631966,"926585570","1977/04/03"),("Liberty","Alvarez Horne","baja",69602866,"644442771","1973/05/08"),("Mary","Walsh Beck","baja",81840074,"955880695","1953/11/13"),("Georgia","Burks Rollins","baja",83950798,"950633543","1968/07/05"),("Quynn","Greer Johns","baja",73118245,"997698109","1962/11/16"),("Laura","Donaldson Lopez","baja",52060178,"675189279","1999/02/16"),("Tanya","Pugh Conley","baja",96268780,"658272878","1979/06/10"),("Chiquita","Cooke Copeland","baja",90595804,"961783842","1979/11/10");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Amena","Olson Padilla","baja",93924655,"618029616","2007/04/15"),("Vincent","Mckinney Ross","baja",61180824,"943483559","1981/01/04"),("Jarrod","Oneal Whitfield","baja",74402790,"983584776","1936/04/28"),("Moana","Kirkland Rosales","baja",53014059,"942098208","2006/06/22"),("Delilah","Benton Ward","baja",79483076,"693451119","1936/10/10"),("Maisie","Oliver Chase","baja",58183578,"985826926","1959/05/04"),("Guinevere","Maldonado Roman","baja",83912711,"998936594","1988/06/24"),("Hasad","Castillo Barry","baja",92742468,"929039142","2003/04/21"),("Christen","Church Patterson","baja",82567929,"686574171","1998/05/20"),("Emi","Osborn Tyson","baja",82203692,"671810250","2011/05/02");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Eliana","Potter Cameron","baja",45541416,"604523683","1944/12/19"),("Amir","Goodwin Ayala","baja",74167020,"906299761","1961/11/30"),("Deacon","Leblanc Harrington","baja",50375079,"999587235","1939/03/29"),("Tamara","Levy Keith","baja",61456175,"950785843","1992/02/15"),("Gannon","Glover Williams","baja",93204708,"693596788","1942/08/22"),("Farrah","Waters Brennan","baja",99916524,"653090980","2003/12/10"),("Cassady","Murphy Kidd","baja",66390707,"670787658","1995/10/24"),("Cynthia","Harvey Allison","baja",53052169,"914841572","1974/09/08"),("Erin","Schmidt Martinez","baja",45619987,"606646881","2002/08/12"),("Bethany","Whitley Mayo","baja",44896802,"657930224","1929/09/26");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Katell","Dunn Carroll","baja",69393037,"660177350","1997/07/24"),("Shaine","Callahan Weeks","baja",79640525,"605014825","1939/04/03"),("Martina","Little Harper","baja",87453143,"953636341","1992/10/23"),("Ariana","Colon Brewer","baja",66483975,"992675987","2004/02/10"),("Ignacia","Hines Matthews","baja",80665113,"904779848","1949/05/26"),("Oren","Townsend Vinson","baja",55193468,"979970943","1967/02/01"),("Hilda","Douglas Gould","baja",64644750,"655779208","2000/09/29"),("Xenos","Head Norris","baja",80930758,"954815752","1960/09/10"),("Buffy","Osborn Cannon","baja",56064316,"914793098","1967/08/25"),("Jaden","Willis Alford","baja",67932781,"679682179","1931/07/09");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Francis","Winters Bates","baja",99575121,"990835980","1985/01/30"),("Bryar","Kennedy Sullivan","baja",95702994,"968108940","1936/10/07"),("Geraldine","Berger Norman","baja",47233284,"640424540","1953/04/01"),("Sigourney","Wynn Holden","baja",80922206,"946016956","1965/10/25"),("Quintessa","Levy Coleman","baja",57637704,"909548251","1970/04/08"),("Dakota","Walker Meyer","baja",53488443,"941842748","1972/12/26"),("Ariana","Bentley Carey","baja",48006422,"981433850","1983/10/20"),("Branden","Johnston Conway","baja",57815465,"658873695","1937/09/18"),("Hiram","Trujillo Reed","baja",73837024,"993133013","2006/03/05"),("Ignacia","Foster Hickman","baja",52145087,"650878381","1963/11/18");
INSERT INTO `usuario` (`nombre`,`apellidos`,`estado`,`dni`,`telefono`,`fecha_nac`) VALUES ("Astra","Spears Vaughan","baja",60419646,"634240864","1936/04/05"),("Rowan","Hoffman Soto","baja",56252935,"685031776","2001/09/21"),("Sara","Bean Lyons","baja",62312109,"935742078","2014/01/29"),("Hilel","Rojas Nguyen","baja",68769436,"638877302","1937/08/02"),("Priscilla","Mcmahon Fry","baja",98050184,"916187377","1987/11/02"),("Dolan","Macdonald Sears","baja",99489661,"996451303","1987/09/25"),("Shelley","Frank Weber","baja",87542839,"603071812","1932/05/15"),("Dante","Lowery Petersen","baja",80994950,"977645864","1992/04/02"),("Jamal","Torres Pennington","baja",77522413,"604936194","1987/06/26"),("Amos","Stafford Holcomb","baja",88489974,"914592065","2015/03/27");


/*
 Campos con Datetime tienen CURRENT_TIMESTAMP por defecto.
 tabla web_service:
 stat_CODE -> stat_code
 se introducen los campos fecha (datetime) y amount (double(10,4)).
 transaction cambia su type a int(255).
 msisdn, shortcode, text y token pasan a ser anulable, stat_code, stat_msg y transaction pasan a ser not null.

 tabla sms:
 Se introduce el campo fecha (datetime).

 tabla cobros:
 Se introduce el campo fecha (datetime).
