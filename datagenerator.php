<?php include_once ('application/snippets/header.php'); ?>
<div class="row">
	<div class="col-12">

<?php

ini_set('max_execution_time', 1800); //300 seconds = 5 minutes

$authors = array('Colon, Gray M.', 'Mclaughlin, Bradley E.', 'West, James O.', 'Pratt, Barbara C.', 'Wise, Grady K.', 'Moses, Nathaniel O.', 'Lindsay, Debra G.', 'Dejesus, Tamekah A.', 'Dalton, Rama L.', 'Kane, Mikayla K.', 'Rose, Germane M.', 'Ashley, Kirsten B.', 'Copeland, Sara I.', 'Rosales, Ainsley C.', 'Buck, Iona V.', 'York, Clementine R.', 'Dorsey, Mona A.', 'Russell, Adele H.', 'Thomas, Oprah G.', 'Jones, Nathan N.', 'Oneill, Serina M.', 'Cleveland, Valentine D.', 'Hays, Kimberley E.', 'Mccarty, Stephen F.', 'Mathis, Gretchen P.', 'Mckinney, Erin E.', 'Bradshaw, Harding V.', 'Waters, Anjolie X.', 'Carney, Hasad Y.', 'Tucker, Mark A.', 'Velasquez, Linda U.', 'Olsen, Katell F.', 'Bradley, Garrison D.', 'Carrillo, Oleg N.', 'Crawford, Rina Z.', 'Fuentes, Mariko G.', 'Goodwin, Brandon M.', 'Keith, Stone N.', 'Rivera, Dale Q.', 'Johnson, Sheila E.', 'Pena, Minerva Z.', 'Leon, Ira D.', 'Harrell, Germane R.', 'Montoya, Deanna Z.', 'Harris, Christen T.', 'Pennington, Felix P.', 'Moses, Reuben W.', 'Barr, Signe G.', 'Webster, Patrick O.', 'Foreman, Aaron G.', 'Stuart, Hyacinth N.', 'Bowers, Kenyon V.', 'Berry, Brody H.', 'Dixon, Barrett D.', 'Bowman, Zena A.', 'Ortega, Aimee I.', 'Sweeney, Quintessa N.', 'Booth, Justina P.', 'Singleton, Selma G.', 'Wilkinson, Molly J.', 'Watson, Pearl W.', 'Peters, Jeanette H.', 'Tyson, Bertha X.', 'Pena, Jakeem F.', 'Olsen, Yuli N.', 'Hammond, Devin L.', 'Clemons, Kaitlin G.', 'Rush, Logan U.', 'Benjamin, Juliet P.', 'Faulkner, Knox B.', 'Huff, Nora P.', 'Fitzpatrick, Nissim X.', 'Craig, Colby E.', 'David, Britanney M.', 'Parks, Virginia E.', 'Richardson, Thane D.', 'Morrow, Kellie D.', 'Tillman, Olympia X.', 'Mckee, Dahlia N.', 'Nicholson, Iona D.', 'Rodgers, Gail Z.', 'Weeks, Elaine H.', 'Hendricks, Wilma T.', 'Silva, Jena K.', 'Benton, Yoshi I.', 'Nielsen, Lacota O.', 'Foley, Kelly P.', 'Salas, Kiona X.', 'Dejesus, Idola N.', 'Conner, Connor K.', 'Sampson, Ralph E.', 'Mayo, Dana O.', 'Odonnell, Hollee N.', 'Gray, Vivian U.', 'Palmer, Barclay F.', 'Hancock, Amanda J.', 'Jensen, Linus F.', 'Oneil, Slade V.', 'Acosta, Quail C.', 'Holder, Mufutau N.');

$titles = array('interdum feugiat Sed nec metus facilisis lorem tristique', 'in faucibus', 'Duis', 'tristique aliquet Phasellus fermentum convallis ligula', 'ac facilisis facilisis, magna tellus', 'pharetra nibh Aliquam ornare, libero at auctor ullamcorper, nisl arcu', 'Curabitur egestas nunc sed libero Proin', 'ut, nulla Cras eu tellus eu', 'nec, mollis vitae, posuere at, velit Cras', 'non, feugiat', 'Praesent eu nulla at', 'dui lectus rutrum', 'ullamcorper, velit in aliquet lobortis,', 'arcu Vestibulum', 'tincidunt tempus', 'augue eu tellus Phasellus elit pede, malesuada vel, venenatis', 'orci Ut semper pretium', 'nunc sit amet metus Aliquam erat volutpat', 'Proin sed turpis nec mauris blandit', 'in, dolor Fusce', 'mi', 'adipiscing Mauris molestie pharetra', 'Morbi', 'mollis non, cursus non, egestas a, dui Cras', 'ligula', 'Curabitur dictum Phasellus in felis Nulla', 'neque pellentesque massa lobortis ultrices', 'a, enim Suspendisse aliquet, sem', 'sit amet,', 'Nulla tincidunt, neque vitae semper egestas, urna justo', 'Vivamus euismod urna Nullam lobortis quam a', 'ligula', 'dapibus ligula Aliquam erat volutpat Nulla dignissim Maecenas', 'pede, malesuada vel,', 'est Nunc laoreet lectus', 'aliquet diam Sed diam lorem, auctor quis, tristique', 'mollis nec, cursus', 'nec urna suscipit nonummy Fusce fermentum', 'luctus', 'vitae velit egestas lacinia', 'Aliquam erat volutpat Nulla dignissim Maecenas', 'egestas Sed pharetra,', 'velit eu sem Pellentesque ut ipsum ac mi eleifend egestas', 'dignissim lacus', 'augue Sed', 'ligula Nullam enim Sed nulla', 'quis, pede Suspendisse', 'semper tellus id nunc interdum feugiat Sed nec metus facilisis', 'ac tellus Suspendisse sed dolor Fusce mi lorem,', 'fermentum risus, at fringilla', 'elit elit fermentum risus, at fringilla purus mauris a', 'velit in aliquet lobortis, nisi nibh lacinia', 'mollis nec, cursus a, enim Suspendisse aliquet, sem ut cursus', 'volutpat ornare, facilisis eget, ipsum Donec sollicitudin adipiscing', 'mauris sit', 'pede Praesent', 'scelerisque, lorem ipsum sodales purus, in molestie', 'tristique', 'purus sapien, gravida non,', 'vel turpis Aliquam adipiscing lobortis risus In mi pede, nonummy', 'malesuada id, erat', 'Pellentesque', 'non sapien molestie orci tincidunt adipiscing Mauris', 'vulputate velit eu sem Pellentesque', 'enim Sed nulla ante, iaculis nec, eleifend', 'dis parturient', 'Nullam feugiat placerat', 'elit,', 'Proin', 'sociis natoque penatibus et magnis', 'pretium neque Morbi quis urna Nunc quis arcu', 'orci', 'tempus risus Donec egestas Duis ac arcu Nunc mauris', 'tincidunt, neque vitae semper egestas, urna', 'vitae, orci Phasellus dapibus quam quis diam Pellentesque habitant', 'sit amet', 'ut quam vel sapien imperdiet ornare In faucibus Morbi', 'ligula Aenean euismod mauris eu elit Nulla facilisi', 'enim Sed nulla ante, iaculis nec, eleifend non, dapibus', 'sed consequat', 'pellentesque eget, dictum placerat,', 'gravida Praesent eu nulla at sem molestie sodales Mauris', 'accumsan neque', 'nisl Maecenas malesuada fringilla est Mauris eu', 'sociis natoque penatibus et magnis dis parturient', 'Ut sagittis lobortis mauris', 'aliquam,', 'placerat, augue Sed molestie Sed', 'ipsum', 'nulla Integer urna Vivamus molestie dapibus ligula Aliquam erat', 'ac metus vitae', 'nunc, ullamcorper eu, euismod ac, fermentum vel, mauris Integer', 'arcu Curabitur ut odio vel est', 'sed sem egestas blandit Nam nulla magna, malesuada', 'molestie', 'auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare', 'luctus,', 'ipsum', 'nascetur ridiculus mus Proin vel arcu eu odio tristique pharetra', 'sapien, gravida non, sollicitudin a, malesuada id, erat');

$isbns = array('1CD6CF1E17678E1AAA01581034863BA5', '73E3C6E18E6579BDFAAC67467FA238AA', 'DC07492B08457CDDF985000ED4B00F8A', 'B965DD456EBEFF48F6BF7CD3C26BE80B', '5C19B1C1B06764D3300A464AD0C1C64D', '60161EDA722C46A4C5E737C340CE99BC', '397DA3507EB59A026EB7D95B13CFA9C3', '1E2D066778FE8634F1299158441AD2A8', '620B3BFBD51659632D3DD08DC335CC12', '4749BE53E1CD5F56C55580A7F681E59D', '28C590BA6363C8CF8E1EB77EAB8FDB32', '88A5CD2CCD99F6AC5DA0F0E24D7E9FA1', 'B775AE1399405772AA2BD47EB402C304', 'D38DEADAF30592E764F996E558119DDF', '758D1A0450EF75D38B77223DB140A832', '5C0412001054E7E4B4F311AE5BA6A2DC', 'D8F762EBAA02D787C5D32D2EAC6FF8CB', '43EEDD669696A2C6EC43239CFA45670C', '539C3F86346B1F195CE06E8A6546BE37', 'CDD13483288FF1D841F2A1F36F83459B', '6631B6154056B300BC11CA9325627257', '3E9911754C5CFDEBD0BF816ADFA007B7', 'DA3A5DFDB2D4D41D5F28D34D589FD1C3', 'D6F6C4022995DBCB447D55EE5E6B44D1', 'F2E84CA969413DF2F9F763B5FE6B5AB8', 'ED076AEFBAE0A35BCABA1D86264D746E', '8F5D1F4653A46CE7F7B19A071693FCE4', '31F68991FF643D78635FB05F0D41B174', '0EDF642026449E35091195BEFD28CECE', '8F7CCE48576F0F30E3A4A424C491C5A8', '179600994F11CC9D858EBA299A0FE344', 'E32880374125A9E853348619223C81FE', 'EFA3C8C6E21EE58597617C8A23AA75F3', '304AB6E39D7BA4FCB735560A6B5063EE', 'CF3ECA4E6AFC9C2302E801B54E5FB7F5', '4853F29578E1A7242BD0C5CFD0E35851', '9AE025321749465A9EB09FCC930076C6', 'E1904DB068A8A0255D602492B4ECB777', 'B1A785AF06A9FC6304225EC7BED1787A', '8C3E80B357974C87CA6987E04F9AB661', '878D3892C08E6FAE06DC622DD286EC0A', 'C39E07D26396A94750228B7E67D38538', 'D22F79FF57E721D13819E6EA2CE61F34', 'ACA7FE69D665E77EA6CA7F1543A08806', 'C5AF7FD71F1AF6EBE1CA66CEBE4E3F3E', '80D415AC43EBB0AF4016B8A52FFA0393', '67A09BF794F598A0C552260CF8428767', 'D470687A90F70D22F6E45DC36E570190', '96EF6E6AB5B6C261C93F27FB2C85035B', 'BA54ED17B10DCAB38FA3841DDCA9E908', '31F49D077C0B3B5414B4320D6D7936A7', '50F5919A724A94D171B04A03EA364C5B', '7B414C2B1C6A1F543B232B77DA1C3CC5', 'A2E10ADC585B7E574423A58C519C7CA9', 'FADE75C79C0D509E5D63600E7D6F9B7D', '3CD0F9FB837E531F276ECE5CBD3C6F3E', '3690910A114D2550FD327394174FD182', '65678B87ED8298C31D71FBD7D7AA8EB7', '5EBBCCBF915D7444DE0CE4FED79F9300', '882BAE2B5EAC41A28C21A426E74B9D6D', 'AD236C832485A4D2BB997290F2FFD4AF', '93597262E7D4EDDFEE8881818A77AE88', '945408AAF649747ABE60F50BF2419972', 'C626882339668AFCCC61A1EEA44198E0', '66BB0FEF35940532B8830486AB3E989F', '8210BF181F9922165EAC2C7C4E4950A7', 'C220D4525D3DBA218279C35587C4FF9D', '4F090117EFE7D9D325C8B031A825951F', 'EA8E2631A78E5204C5DD6D5B7A54866D', '43930B78D4E5B852025E81D30E6FE025', '5F7FAAB68DA95DE4FCEE6243C4D2D3C2', '5DD9796B8746BE3C11E82DFE72EB65C7', 'AA9C85E264456224A0D7D3772631AF04', 'DED8F5C43035DA9CF604C62D9FF23BE8', '7FDC1C6CF7E2912487D25FA26EDF65B1', 'C9C596BA2B8EB391D25C507502A48C44', '738F258D0EAAD59DE9051F7181C0D9CA', '22EB508F9BA0C332655DA907462D1B7B', '07A520C2E45E8F54123C99C28E51AF64', '7A508A1E62C7814615587031A3DF8C2F', '2094D52B743B969EF585BF86DF83AE11', 'A6DE4B492C9BF352D33CD934F47A7640', '8578975BF99DE9F08269CF1C495A5390', '38992A58148C526227564C36B8BA9DFC', '1D1FF5084C0AA061B11F2A9017BD5164', '66AE98976E83525F4660E0CF321715D1', '458F939456F15B98789C13921D862DAD', 'B7571AE6437A4DFF43C6954B19535BCE', '900F46306CFFDC5FCB80AB8A1A1F6079', 'F22DAEFDE8B26745BC96FF51F9E4D124', '05244D68D533BA3F4BD7E73DB2CD7837', '0A93219FA4351298E28E23878C052502', '242FB4F0F7C0DA6F73E84A9BA28F107F', 'A036AF5BD933D45C3B1157A96828EDC0', 'C2A6EDBD6D98324FE6B02577EFD2FF79', '094C6E17DEED2F63DF809A56269C7CAD', '190BA9D91448ABADAAE41B53048BC1C3', '839EEBAF88D05F3741200FE5FCEB1287', '28CC724ABFBC2390A812CA925E41C645', '763E3EA4268E9240F9A0B12E2288E51D');

$publishers = array('Semper Industries', 'Risus Duis A Incorporated', 'Nibh Enim Gravida Foundation', 'Felis LLP', 'Enim Commodo Institute', 'Fringilla Ornare Associates', 'Natoque LLP', 'Orci Consectetuer Euismod Corp.', 'Eleifend Non Dapibus Institute', 'Mollis Lectus LLC', 'Etiam LLC', 'Semper Auctor LLC', 'Augue Corporation', 'In Tempus Eu Corporation', 'Mattis Semper Dui LLC', 'Massa Suspendisse Eleifend Industries', 'Nec Euismod In Corp.', 'Mauris Ut Industries', 'Dui Nec LLP', 'Eu Erat Semper Foundation', 'Ornare Lectus Justo Institute', 'Donec At Institute', 'Diam Proin Ltd', 'Scelerisque Corporation', 'A Magna Lorem Corporation', 'Malesuada Id Ltd', 'In Lobortis PC', 'Felis Adipiscing Fringilla Institute', 'Conubia Corporation', 'Scelerisque Neque Nullam Institute', 'Mi Aliquam Inc.', 'Nibh Lacinia Orci Institute', 'Dui Quis Accumsan Limited', 'Lobortis Risus In Ltd', 'Eleifend Vitae Erat LLC', 'Blandit Nam Ltd', 'Odio Consulting', 'Eget Laoreet Posuere Inc.', 'Arcu Nunc Mauris Incorporated', 'Integer Id Magna Limited', 'Elit Sed Consequat Industries', 'In Magna Phasellus Consulting', 'Cursus Corporation', 'Ipsum Consulting', 'Sem Semper Ltd', 'Imperdiet Erat Associates', 'Urna Convallis Erat Incorporated', 'Sed Neque Sed Limited', 'Vitae Aliquet Company', 'Ut Ipsum LLP', 'Integer Mollis Integer Institute', 'In Cursus Et Corp.', 'Felis Foundation', 'Sed Pede Corporation', 'Eu Lacus Quisque Industries', 'Vivamus Molestie Inc.', 'Massa Rutrum Magna Corp.', 'Semper Pretium Neque Foundation', 'Neque Venenatis Lacus Ltd', 'Dolor LLP', 'Libero Est Foundation', 'Sociis Natoque Industries', 'Pellentesque Tellus Sem Inc.', 'Tempus Lorem Foundation', 'Sem Consequat Nec PC', 'Phasellus Elit Consulting', 'Lectus A Associates', 'Lobortis Associates', 'Class Aptent Corporation', 'Orci In Incorporated', 'Non Egestas A LLP', 'Fringilla Porttitor Incorporated', 'Nisl PC', 'Nonummy Ac Incorporated', 'Eros Turpis Non Institute', 'Et Netus Et Ltd', 'Vel Incorporated', 'Eget Metus In Institute', 'Sit Amet Faucibus Corp.', 'Ligula Aenean LLC', 'Aliquam Adipiscing Consulting', 'Nunc Corp.', 'Elementum Associates', 'Nascetur Ridiculus Mus Consulting', 'Pede Cum Sociis Institute', 'Lorem Fringilla PC', 'Et Magnis PC', 'Sed Hendrerit A PC', 'Ut Aliquam Consulting', 'Lacus Quisque Associates', 'Consectetuer Cursus Et Incorporated', 'Eu Augue Porttitor Limited', 'Vestibulum Ut Eros LLP', 'Eget Magna Foundation', 'Et LLP', 'In Incorporated', 'Vitae Associates', 'Ornare Libero At Inc.', 'Sed Ltd', 'Neque Foundation');

$years = array('2018', '2016', '2017', '2017', '2017', '2018', '2017', '2017', '2018', '2018', '2017', '2017', '2018', '2017', '2018', '2017', '2016', '2018', '2018', '2017', '2018', '2017', '2018', '2017', '2018', '2018', '2018', '2017', '2017', '2016', '2016', '2018', '2018', '2017', '2018', '2017', '2018', '2017', '2017', '2018', '2017', '2017', '2018', '2017', '2018', '2018', '2018', '2018', '2018', '2018', '2018', '2017', '2017', '2017', '2017', '2018', '2018', '2017', '2016', '2017', '2016', '2018', '2018', '2018', '2018', '2018', '2017', '2018', '2018', '2017', '2017', '2018', '2017', '2018', '2017', '2017', '2017', '2018', '2017', '2017', '2017', '2018', '2018', '2018', '2017', '2017', '2017', '2016', '2018', '2017', '2017', '2017', '2017', '2018', '2018', '2018', '2018', '2017', '2018', '2018');

$genres = array('tristique ac', 'Proin', 'lacus vestibulum', 'varius et', 'vulputate risus', 'Pellentesque habitant', 'id sapien', 'Cras', 'est ac', 'magna', 'amet', 'ornare', 'enim commodo', 'erat vel', 'non arcu', 'tristique senectus', 'amet diam', 'Aliquam', 'urna', 'lorem', 'lorem', 'lacinia at', 'Morbi', 'netus', 'nonummy', 'Proin', 'amet', 'lacus varius', 'Nulla aliquet', 'justo Praesent', 'et magnis', 'augue eu', 'rhoncus Donec', 'imperdiet', 'mus', 'enim gravida', 'tristique', 'magnis dis', 'Phasellus', 'ipsum', 'enim', 'lectus', 'neque sed', 'imperdiet', 'tincidunt dui', 'egestas', 'tincidunt', 'lacinia mattis', 'odio Nam', 'parturient', 'molestie', 'mauris', 'ipsum', 'tempus', 'imperdiet', 'Curabitur vel', 'non', 'Praesent', 'enim gravida', 'purus Nullam', 'tincidunt', 'faucibus orci', 'neque sed', 'laoreet', 'et', 'diam', 'pede', 'neque tellus', 'magna Praesent', 'risus quis', 'mus', 'lacinia at', 'Sed nulla', 'nulla Integer', 'quis', 'et malesuada', 'venenatis a', 'mauris ipsum', 'malesuada', 'non', 'posuere at', 'imperdiet', 'sagittis', 'justo', 'cursus', 'penatibus', 'ut dolor', 'aliquet', 'ullamcorper eu', 'bibendum sed', 'enim', 'semper', 'Mauris blandit', 'convallis dolor', 'pulvinar', 'habitant', 'auctor Mauris', 'aliquet', 'risus quis', 'sed');

$descriptions = array('desc Curae; Donec tincidunt.', 'Donec vitae erat vel pede erat volutpat.', 'Nulla facilisis.', 'Suspendisse commodo tincidunt nibh.', 'vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci augue, eu tempor erat neque non quam.', 'Pellentesque neque tellus, imperdiet non, vestibulum nec, euismod in, dolor.', 'accumsan sed, facilisis vitae, orci.', 'Phasellus dapibus quam quis diam.', 'Pellentesque habitant adipiscing elit.', 'Aliquam auctor, velit eget laoreet posuere, enim vitae semper egestas, urna justo faucibus lectus, a sollicitudin commodo hendrerit.', 'Donec porttitor tellus non magna.', 'Nam ligula elit, pretium et, Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero.', 'leo elementum sem, vitae aliquam eros turpis non sit amet risus.', 'Donec egestas.', 'Aliquam nec enim.', 'Nunc Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.', 'lacus.', 'Quisque imperdiet, erat nonummy ultricies ornare, elit consectetuer mauris id sapien.', 'Cras dolor dolor, tempus ultricies sem magna nec quam.', 'Curabitur vel lectus.', 'montes, nascetur ridiculus mus.', 'Donec dignissim magna a elit, pharetra ut, pharetra sed, hendrerit a, arcu.', 'ligula.', 'Aenean gravida nunc sed pede.', 'Cum sociis natoque penatibus et semper et, lacinia vitae, sodales at, velit.', 'Pellentesque ultricies Curabitur dictum.', 'Phasellus in felis.', 'Nulla tempor augue ac ipsum.', 'Phasellus iaculis nec, eleifend non, dapibus rutrum, justo.', 'Praesent luctus.', 'Curabitur fames ac turpis egestas.', 'Aliquam fringilla cursus purus.', 'mollis.', 'Integer tincidunt aliquam arcu.', 'Aliquam ultrices iaculis odio.', 'Nam interdum enim lorem, auctor quis, tristique ac, eleifend vitae, erat.', 'Vivamus nisi.', 'Mauris nulla.', 'Donec fringilla.', 'Donec feugiat metus sit amet ante.', 'Vivamus non lorem vitae odio tristique pharetra.', 'Quisque ac libero nec ligula consectetuer rhoncus.', 'Nullam ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus.', 'tellus.', 'Suspendisse sed dolor.', 'Fusce mi lorem, vehicula diam.', 'Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum.', 'at fringilla purus mauris a nunc.', 'In at pede.', 'ac nulla.', 'In tincidunt congue turpis.', 'In condimentum.', 'Donec at tortor nibh sit amet orci.', 'Ut sagittis lobortis mauris.', 'Suspendisse aliquet molestie sit amet nulla.', 'Donec non justo.', 'Proin non ut lacus.', 'Nulla tincidunt, neque vitae semper egestas, urna dapibus quam quis diam.', 'Pellentesque habitant morbi tristique senectus Morbi non sapien molestie orci tincidunt adipiscing.', 'Mauris molestie pharetra velit.', 'Aliquam nisl.', 'Nulla eu neque pellentesque massa lectus rutrum urna, nec luctus felis purus ac tellus.', 'semper rutrum.', 'Fusce dolor quam, elementum at, egestas arcu et pede.', 'Nunc sed orci lobortis augue scelerisque mollis.', 'ac mattis ornare, lectus ante dictum mi, ac mattis velit justo nec amet ante.', 'Vivamus non lorem vitae odio sagittis semper.', 'Nam Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia parturient montes, nascetur ridiculus mus.', 'Proin vel nisl.', 'Suspendisse non leo.', 'Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, metus.', 'Vivamus euismod urna.', 'Nullam lobortis quam a felis ullamcorper viverra.', 'Cras vehicula aliquet libero.', 'Integer in magna.', 'Phasellus at, nisi.', 'Cum sociis natoque penatibus et magnis dis ac turpis egestas.', 'Aliquam fringilla cursus purus.', 'Nullam scelerisque ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus dignissim.', 'Maecenas ornare egestas ligula.', 'Nullam feugiat placerat velit.', 'eu tellus eu augue porttitor interdum.', 'Sed auctor odio a purus.', 'Aenean euismod mauris eu elit.', 'Nulla facilisi.', 'Sed Proin sed turpis nec mauris blandit mattis.', 'Cras eget massa non ante bibendum ullamcorper.', 'Duis cursus, diam at pretium aliquet, metus ante ipsum primis in faucibus orci luctus et ultrices posuere erat neque non quam.', 'Pellentesque habitant morbi tristique senectus et semper.', 'Nam tempor diam dictum sapien.', 'Aenean massa.', 'Integer velit dui, semper et, lacinia vitae, sodales at, velit.', 'Pellentesque ultricies vehicula.', 'Pellentesque tincidunt tempus risus.', 'Donec egestas.', 'Duis ac nisi.', 'Aenean eget metus.', 'In nec orci.', 'Donec nibh.', 'at, libero.', 'Morbi accumsan laoreet ipsum.', 'Curabitur consequat, nulla at sem molestie sodales.', 'Mauris blandit enim consequat purus.', 'aliquam eu, accumsan sed, facilisis vitae, orci.', 'Phasellus orci.', 'Phasellus dapibus quam quis diam.', 'Pellentesque habitant morbi pharetra ut, pharetra sed, hendrerit a, arcu.', 'Sed et libero.', 'Proin consectetuer mauris id sapien.', 'Cras dolor dolor, tempus non, lacinia at, orci, in consequat enim diam vel arcu.', 'Curabitur ut erat volutpat.', 'Nulla facilisis.', 'Suspendisse commodo tincidunt nibh.', 'Aliquam ultrices iaculis odio.', 'Nam interdum enim non nisi.', 'congue a, aliquet vel, vulputate eu, odio.', 'Phasellus at augue id lacus.', 'Quisque purus sapien, gravida non, sollicitudin a, malesuada id, Nullam scelerisque neque sed sem egestas blandit.', 'Nam nulla magna, malesuada vel, urna.', 'Vivamus molestie dapibus ligula.', 'Aliquam erat volutpat.', 'Nulla dignissim.', 'Maecenas Proin dolor.', 'Nulla semper tellus id nunc interdum feugiat.', 'Sed nec feugiat tellus lorem eu metus.', 'In lorem.', 'Donec Donec nibh.', 'Quisque nonummy ipsum non arcu.', 'Vivamus sagittis semper.', 'Nam tempor diam dictum sapien.', 'Aenean sagittis.', 'Nullam vitae diam.', 'Proin dolor.', 'Nulla semper tellus id commodo ipsum.', 'Suspendisse non leo.', 'Vivamus nibh dolor, nonummy ac, feugiat non, sapien.', 'Aenean massa.', 'Integer vitae nibh.', 'Donec est mauris, felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus.', 'Cras interdum.', 'Nunc sollicitudin nisi sem semper erat, in consectetuer ipsum nunc id Praesent eu dui.', 'Cum sociis natoque penatibus et magnis dis parturient montes, blandit at, nisi.', 'Cum sociis natoque penatibus et magnis et, eros.', 'Proin ultrices.', 'Duis volutpat nunc sit amet metus.', 'Aliquam sagittis.', 'Nullam vitae diam.', 'Proin dolor.', 'Nulla semper tellus id nunc odio, auctor vitae, aliquet nec, imperdiet nec, leo.', 'Morbi neque tellus, imperdiet ultrices sit amet, risus.', 'Donec nibh enim, gravida sit posuere, enim nisl elementum purus, accumsan interdum libero odio a purus.', 'Duis elementum, dui quis accumsan convallis, ante lectus ipsum dolor sit amet, consectetuer adipiscing elit.', 'Aliquam auctor, velit eget metus.', 'In nec orci.', 'Donec nibh.', 'Quisque nonummy tortor.', 'Integer aliquam adipiscing lacus.', 'Ut nec urna suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lacinia vitae, sodales at, velit.', 'Pellentesque ultricies dignissim lacus.', 'Aliquam rutrum lorem sit amet, risus.', 'Donec nibh enim, gravida sit amet, dapibus consectetuer mauris id sapien.', 'Cras dolor dolor, tempus non, lacinia at, tempus eu, ligula.', 'Aenean euismod mauris eu elit.');

$locations = array('amet', 'quis', 'in', 'sodales', 'lorem semper', 'ante Nunc', 'commodo', 'Suspendisse', 'odio tristique', 'pede nec', 'Suspendisse', 'facilisis', 'est', 'Cras', 'Proin ultrices', 'Sed', 'nisl', 'neque', 'dapibus', 'ridiculus mus', 'magna malesuada', 'ornare', 'sodales elit', 'tristique', 'In', 'tristique', 'tempus risus', 'pede Nunc', 'fringilla est', 'at', 'erat neque', 'semper et', 'Duis sit', 'elit', 'Curabitur', 'in', 'risus Quisque', 'Mauris vel', 'ipsum', 'nascetur ridiculus', 'interdum libero', 'arcu', 'leo Cras', 'eu lacus', 'placerat orci', 'erat Etiam', 'nunc', 'Integer mollis', 'Curabitur massa', 'natoque penatibus', 'pede', 'lectus Cum', 'gravida', 'dictum', 'nibh Phasellus', 'Nulla aliquet', 'placerat Cras', 'mi pede', 'tincidunt congue', 'eget', 'consequat dolor', 'parturient montes', 'nisl elementum', 'Suspendisse aliquet', 'at', 'risus Quisque', 'quam Curabitur', 'Etiam', 'consectetuer adipiscing', 'ante ipsum', 'pellentesque massa', 'risus Morbi', 'feugiat', 'non', 'Praesent', 'nisi', 'Nulla facilisi', 'Duis', 'ac mattis', 'dignissim', 'rhoncus', 'nibh vulputate', 'nec tempus', 'ante', 'gravida', 'convallis erat', 'vitae nibh', 'lacus pede', 'egestas', 'non', 'enim', 'Vivamus', 'molestie dapibus', 'vestibulum', 'ac', 'libero mauris', 'iaculis', 'Phasellus in', 'cursus in', 'neque sed');

$i = 1;
while ($i <= 20) {

// author(s)
	$authorNum = rand(1,2);
	$authorMax = count($authors) - 1;
	$ia = 1;
	$authorArray = array();

	while ($ia <= $authorNum) {
		$authorRandom = rand(1, $authorMax);
		$author = $authors[$authorRandom];
		$authorArray[] = $author;
		$ia++;
	}
	$authorReady = implode('; ', $authorArray);

// title
	$titleMax = count($titles) - 1;
	$titleRandom = rand(1, $titleMax);
	$titleReady = $titles[$titleRandom];

// isbn
	$isbnMax = count($isbns) - 1;
	$isbnRandom = rand(1, $isbnMax);
	$isbnReady = $isbns[$isbnRandom];

// publisher
	$publisherMax = count($publishers) - 1;
	$publisherRandom = rand(1, $publisherMax);
	$publisherReady = $publishers[$publisherRandom];

// year
	$yearMax = count($years) - 1;
	$yearRandom = rand(1, $yearMax);
	$yearReady = $years[$yearRandom];

// genre(s)
	$genreNum = rand(1,2);
	$genreMax = count($genres) - 1;
	$ig = 1;
	$genreArray = array();

	while ($ig <= $genreNum) {
		$genreRandom = rand(1, $titleMax);
		$genre = $genres[$genreRandom];
		$genreArray[] = $genre;
		$ig++;
	}
	$genreReady = implode('; ', $genreArray);

// description(s)
	$descriptionNum = rand(4,6);
	$descriptionMax = count($descriptions) - 1;
	$ide = 1;
	$descriptionArray = array();

	while ($ide <= $descriptionNum) {
		$descriptionRandom = rand(1, $titleMax);
		$description = $descriptions[$descriptionRandom];
		$descriptionArray[] = $description;
		$ide++;
	}
	$descriptionReady = implode(' ', $descriptionArray);

// location
	$locationMax = count($locations) - 1;
	$locationRandom = rand(1, $locationMax);
	$locationReady = $locations[$locationRandom];

	$folder = new folder('data/books');
	$data = $folder->files();
	$itemsCount = $data->count();
	$fileId = 0 + $itemsCount + 1;
	$authorReady = rtrim($authorReady, '; ') . '';
	$authorReady = explode(';', $authorReady);
	$authorReady = array_map('trim', $authorReady);
	$genreReady = rtrim($genreReady, '; ') . '';
	$genreReady = explode(';', $genreReady);
	$genreReady = array_map('trim', $genreReady);
	$bookNew = array(
		'id' => $fileId,
		'title' => $titleReady,
		'author' => $authorReady,
		'isbn' => $isbnReady,
		'publisher' => $publisherReady,
		'year' => $yearReady,
		'genres' => $genreReady,
		'cover' => '',
		'description' => $descriptionReady,
		'location' => $locationReady
	);
	$fileName = str_pad($fileId, 6, '0', STR_PAD_LEFT);

	yaml::write('data/books/'.$fileName.'.yml', $bookNew);

echo 'Item number #'.$i.' generated.<br />';
$i++;
}

echo 'Done.';

?>

</div>
</div>
<?php include_once ('application/snippets/footer.php'); ?>
