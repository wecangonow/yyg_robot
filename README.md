# This is yyg robot server

安装docker

git clone https://github.com/koolob/swoole-docker-example.git

cd swoole-docker-example

bash ./build.sh

浏览器访问 http://容器ip:8080

alter table `sp_rt_regular` Add column percent varchar(10) default "%100" AFTER `id`;
alter table `sp_rt_regular` Add column run_hour varchar(2) default "0" AFTER `id`;
alter table `sp_rt_regular` Add column speed_x tinyint(2) default 1 AFTER `id`;
alter table `sp_rt_regular` Add column money_x tinyint(2) default 1 AFTER `id`;
