USE stiki;
CREATE TABLE users
(
    id       int                       not null AUTO_INCREMENT,
    email    varchar(512)              not null unique,
    name     varchar(256)              not null,
    password varchar(512)              not null,
    type     enum ('official', 'user') not null default 'user',
    created_at timestamp               not null default current_timestamp,
    updated_at timestamp               not null default current_timestamp,
    constraint users_pk primary key (id)
);

CREATE TABLE reports
(
    id       int                       not null AUTO_INCREMENT,
    address     varchar(512) not null,
    photo       varchar(512) not null,
    user_id     varchar(36)  not null references users (id) on update cascade on delete cascade,
    cache_votes int                   default 0,
    created_at timestamp               not null default current_timestamp,
    updated_at timestamp               not null default current_timestamp,
    constraint users_pk primary key (id)
);

create table report_votes
(
    id       int                       not null AUTO_INCREMENT,
    user_id   varchar(36)                   not null references users (id) on update cascade on delete cascade,
    report_id varchar(36)                   not null references reports (id) on update cascade on delete cascade,
    type      enum ('positive', 'negative') not null,
    created_at timestamp               not null default current_timestamp,
    updated_at timestamp               not null default current_timestamp,
    constraint users_pk primary key (id)
);

DELIMITER ///
CREATE TRIGGER update_report_cache_votes_on_insert
    AFTER INSERT
    ON report_votes
    FOR EACH ROW
BEGIN
    SET @positiveCount = 0;
    SET @negativeCount = 0;
    SELECT COUNT(*) INTO @positiveCount FROM report_votes WHERE type = 'positive' AND report_id = NEW.report_id;
    SELECT COUNT(*) INTO @negativeCount FROM report_votes WHERE type = 'negative' AND report_id = NEW.report_id;
    UPDATE reports SET cache_votes = @positiveCount - @negativeCount WHERE reports.id = NEW.report_id;
end;
///
DELIMITER ///
CREATE TRIGGER update_report_cache_votes_on_update
    AFTER UPDATE
    ON report_votes
    FOR EACH ROW
BEGIN
    SET @positiveCount = 0;
    SET @negativeCount = 0;
    SELECT COUNT(*) INTO @positiveCount FROM report_votes WHERE type = 'positive' AND report_id = NEW.report_id;
    SELECT COUNT(*) INTO @negativeCount FROM report_votes WHERE type = 'negative' AND report_id = NEW.report_id;
    UPDATE reports SET cache_votes = @positiveCount - @negativeCount WHERE reports.id = NEW.report_id;
end;
///
DELIMITER ///
CREATE TRIGGER update_report_cache_votes_on_delete
    AFTER DELETE
    ON report_votes
    FOR EACH ROW
BEGIN
    SET @positiveCount = 0;
    SET @negativeCount = 0;
    SELECT COUNT(*) INTO @positiveCount FROM report_votes WHERE type = 'positive' AND report_id = OLD.report_id;
    SELECT COUNT(*) INTO @negativeCount FROM report_votes WHERE type = 'negative' AND report_id = OLD.report_id;
    UPDATE reports SET cache_votes = @positiveCount - @negativeCount WHERE reports.id = OLD.report_id;
end;
///
