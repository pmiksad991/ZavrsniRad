create table korisnik(
id int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
email varchar(50) not null,
username varchar(50) not null,
pass varchar(50) not null,
admin bool not null,
radno_mjesto int not null,
bodovi int
);

create table radno_mjesto(
id int not null primary key auto_increment,
naziv varchar(50) not null
);

create table smjene(
id int not null primary key auto_increment,
naziv varchar(50) not null
);

create table dodjeljene_smjene(
id int not null primary key auto_increment,
id_korisnika int not null,
id_smjene int not null,
datum date not null
);

create table zamjena(
id int not null primary key auto_increment,
korisnik1 int not null,
korisnik2 int not null,
datum_korisnika1 date not null,
datum_korisnika2 date not null,
smjena_korisnika1 int not null,
smjena_korisnika2 int not null,
zamjena_obavljena bool
);

create table poruke(
id int not null primary key auto_increment,
primio int not null,
poslao int not null,
sadrzaj varchar(500) not null,
datum_vrijeme datetime not null,
procitana bool
);

alter table korisnik add foreign key (radno_mjesto) references radno_mjesto(id);
alter table dodjeljene_smjene add foreign key (id_korisnika) references korisnik(id);
alter table dodjeljene_smjene add foreign key (id_smjene) references smjene(id);
alter table zamjena add foreign key (korisnik1) references korisnik(id);
alter table zamjena add foreign key (korisnik2) references korisnik(id);
alter table zamjena add foreign key (smjena_korisnika1) references smjene(id);
alter table zamjena add foreign key (smjena_korisnika2) references smjene(id);
alter table poruke add foreign key (primio) references korisnik(id);
alter table poruke add foreign key (poslao) references korisnik(id);


insert into korisnik (id, ime, prezime, email, username, pass, admin, radno_mjesto, bodovi) values
(null, "Pavel", "Miksad", "pmiksad@email.com", "pmiksad", md5("123456"), 1, 2, 2);

select * from korisnik where admin=1;

update korisnik set ime="Tomislav", prezime="Tomic", email="ttomic@email.com", username="ttomic", admin=0, radno_mjesto=2, bodovi=3 where id=1;

select a.id, a.ime, a.prezime, b.naziv from korisnik as a inner join radno_mjesto as b on a.radno_mjesto=b.id;

select a.id, a.datum, a.id_korisnika, b.ime, b.prezime, b.radno_mjesto, a.id_smjene, c.naziv from dodjeljene_smjene as a inner join korisnik as b on a.id_korisnika=b.id inner join smjene as c on a.id_smjene=c.id where a.datum='2018-02-20' and b.radno_mjesto=2;

select a.id, a.id_korisnika, a.datum, b.ime, b.prezime from dodjeljene_smjene as a inner join korisnik as b on a.id_korisnika=b.id where a.id=20;

select * from dodjeljene_smjene where id_korisnika = 1 and datum>=CURDATE();

select * from zamjena;

insert into zamjena (id, korisnik1, korisnik2, datum_korisnika1, datum_korisnika2, smjena_korisnika1, smjena_korisnika2, zamjena_obavljena) values (null, 1, 2, CURDATE(), CURDATE(), 1, 2, null);

select a.id, b.ime, b.prezime, a.datum_korisnika1, a.datum_korisnika2, a.smjena_korisnika1, a.smjena_korisnika2 from zamjena as a inner join korisnik as b on b.id=a.korisnik2;