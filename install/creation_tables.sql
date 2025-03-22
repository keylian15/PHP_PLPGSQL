/* Creation de la base IUT : tables etudiants, enseignants, */
/* avoir_note, faire_cours, epreuves, matieres et modules   */
/* creation : 11-09-1996                                    */
/* auteur : B. Talon                                        */
/* date de version : 17-10-2023                             */
/* auteur : K. GUERRIER                                     */

drop table if exists etudiants CASCADE;
drop table if exists enseignants CASCADE;
drop table if exists avoir_note CASCADE;
drop table if exists faire_cours CASCADE;
drop table if exists epreuves CASCADE;
drop table if exists matieres CASCADE;
drop table if exists modules CASCADE;

create table etudiants (
   numetu integer primary key,
   nometu varchar(20) not null,
   prenometu varchar(20),
   adretu varchar(40),
   viletu varchar(10),
   cpetu integer,
   teletu varchar(14),
   datentetu date,
   annetu integer constraint ck_etu_annee check (annetu in (1,2)), 
   remetu varchar(40),
   sexetu char(1) constraint ck_etu_sex check (sexetu in ('M','F')),
   datnaietu date);

create table enseignants (
   numens integer primary key,
   nomens varchar(20) not null,
   preens varchar(20),
   foncens varchar(25) constraint ck_ens_fonc check (foncens in ('AGREGE', 'CERTIFIE', 'MAITRE DE CONFERENCES', 'VACATAIRE')),
   adrens varchar(40),
   vilens varchar(10),
   cpens integer,
   telens varchar(14),
   datnaiens date,
   datembens date);
  
create table modules (
   nummod integer primary key,
   nommod varchar(15) not null,
   coefmod integer);

create table matieres (
   nummat integer primary key,
   nommat varchar(15) not null,
   nummod integer references modules (nummod),
   coefmat integer);

create table epreuves (
   numepr integer primary key,
   libepr varchar(20),
   ensepr integer not null references enseignants (numens),
   matepr integer not null references matieres (nummat),
   datepr date,
   coefepr integer not null,
   annepr integer);


create table avoir_note (
   numetu integer references etudiants (numetu),
   numepr integer references epreuves (numepr),
   note integer,
   primary key (numetu, numepr));

create table faire_cours (
   numens integer references enseignants (numens),
   nummat integer references matieres (nummat),
   annee integer,
   primary key (numens, nummat, annee));
