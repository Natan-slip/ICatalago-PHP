create database icatalogo;

use icatalogo;

create table tbl_produto(
    id int primary key auto_increment,
    descricao varchar(255) not null,
    peso decimal (10,2) not null,
    quantidade int not null,
    cor varchar(100) not null,
    tamanho varchar(100),
    valor decimal (10,2) not null,
    desconto int,
    imagem varchar(500)
);

create table tbl_administrador(
    id int primary key auto_increment,
    nome varchar(255) not null,
    usuario varchar(255) not null,
    senha varchar (255) not null
    );

create table tbl_categoria (
    id int primary key auto_increment,
    descricao varchar(255) not null
);

insert into tbl_administrador values (10, "Matheus", "maoxoo", 13128359);

insert into tbl_administrador(nome, usuario, senha) values ("Ana", "aninha33", "superman33");

insert into tbl_administrador(nome, usuario, senha) values ("Zé", "zezin", "123");

drop table tbl_produto;

drop table tbl_administrador;

DELETE FROM tbl_produto WHERE id > 0;

DELETE FROM tbl_administrador WHERE id = 2;

delete from tbl_categoria where id > 0;

select * from tbl_produto;

select * from tbl_administrador;

SELECT * FROM tbl_administrador WHERE usuario = 'maoxoo' and senha = '13128359';

select * from tbl_categoria;

select p.*, c.descricao as categoria from tbl_produto p
inner join tbl_categoria c on p.categoria_id = c.id
order by p.id desc;

truncate tbl_produto;

alter table tbl_produto
add column categoria_id int,
add foreign key (categoria_id) references tbl_categoria(id);

select p.*, c.descricao as categoria from tbl_produto p
inner join tbl_categoria c on p.categoria_id = c.id
where p.descricao like "Mochila"
or c.descricao like "Mochila"
order by p.id desc;