create table if not exists `users` (`id` bigint not null auto_increment, primary key (`id`)) engine = InnoDB;

create table `statuses` (
  `id`    bigint not null auto_increment,
  `name`  varchar(50) not null,
  `rank`  tinyint not null default '0',
  `flags` int not null default '0',
  primary key (`id`)
) engine = InnoDB;

create table `payments` (
  `id`    bigint not null auto_increment,
  `name`  varchar(50) not null,
  `rank`  tinyint not null default '0',
  `flags` int not null default '0',
  primary key (`id`)
) engine = InnoDB;

create table `services` (
  `id`    bigint not null auto_increment,
  `name`  varchar(200) not null,
  `type`  tinyint not null default '0',
  `price` float not null default '0',
  `rank`  int not null default '0',
  `flags` int not null default '0',
  primary key (`id`)
) engine = InnoDB;

create table `leads` (
  `id`      bigint not null auto_increment,
  `type`    tinyint not null default '0',
  `patient` bigint not null,
  `expert`  bigint null,
  `status`  bigint null,
  `payment` bigint null,
  `created` datetime not null,
  `served`  datetime null,
  `updated` datetime null,
  `deleted` datetime null,
  primary key (`id`),
  foreign key (`patient`) references `users`(`id`)    on update cascade  on delete cascade,
  foreign key (`expert`)  references `users`(`id`)    on update set null on delete set null,
  foreign key (`status`)  references `statuses`(`id`) on update set null on delete set null,
  foreign key (`payment`) references `payments`(`id`) on update set null on delete set null
) engine = InnoDB;

create table `leads_payments` (
  `lead`    bigint not null,
  `payment` bigint not null,
  `comment` text null,
  `created` datetime not null,
  foreign key (`lead`)    references `leads`   (`id`) on update cascade on delete cascade,
  foreign key (`payment`) references `payments`(`id`) on update cascade on delete cascade
) engine = InnoDB;

create table `leads_statuses` (
  `lead`    bigint not null,
  `status`  bigint not null,
  `comment` text null,
  `created` datetime not null,
  foreign key (`lead`)   references `leads`   (`id`) on update cascade on delete cascade,
  foreign key (`status`) references `statuses`(`id`) on update cascade on delete cascade
) engine = InnoDB;

create table `carts` (
  `lead`    bigint not null,
  `service` bigint not null,
  `count`   int not null default '1',
  foreign key (`lead`)    references `leads`   (`id`) on update cascade on delete cascade,
  foreign key (`service`) references `services`(`id`) on update cascade on delete cascade
) engine = InnoDB;

create table `comments` (
  `id`   bigint not null auto_increment,
  `lead` bigint not null,
  `from` bigint not null,
  `text` text null,
  `created` datetime not null,
  primary key (`id`),
  foreign key (`lead`) references `leads`(`id`) on update cascade on delete cascade,
  foreign key (`from`) references `users`(`id`) on update cascade on delete cascade
) engine = InnoDB;