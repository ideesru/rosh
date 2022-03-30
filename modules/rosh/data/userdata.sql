create table `users_data` (
  `user` bigint not null,
  `fio`  varchar(200) null,
  primary key (`user`),
  foreign key (`user`) references `users`(`id`) on update cascade on delete cascade
) engine = InnoDB;