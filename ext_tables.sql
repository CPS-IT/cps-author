#
# Table definition for "tx_cpsauthor_domain_model_author_author"
#
CREATE TABLE tx_cpsauthor_domain_model_author
(
    uid              int(11) auto_increment          NOT NULL,
    pid              int(11)             DEFAULT '0' NOT NULL,
    tstamp           int(11)             DEFAULT '0' NOT NULL,
    crdate           int(11)             DEFAULT '0' NOT NULL,
    cruser_id        int(11)             DEFAULT '0' NOT NULL,
    deleted          tinyint(3)          DEFAULT '0',
    hidden           tinyint(4)          DEFAULT '0' NOT NULL,
    starttime        int(11)             DEFAULT '0' NOT NULL,
    endtime          int(11)             DEFAULT '0' NOT NULL,
    fe_group         varchar(100)        DEFAULT '0' NOT NULL,
    sorting          int(11)             DEFAULT '0' NOT NULL,

    type             tinyint(3) unsigned DEFAULT '0' NOT NULL,
    slug             varchar(2048),
    gender           varchar(1)          DEFAULT ''  NOT NULL,
    first_name       tinytext,
    middle_name      tinytext,
    last_name        tinytext,
    email            varchar(255)        DEFAULT ''  NOT NULL,
    phone            varchar(30)         DEFAULT ''  NOT NULL,
    fax              varchar(30)         DEFAULT ''  NOT NULL,
    mobile           varchar(30)         DEFAULT ''  NOT NULL,
    www              varchar(255)        DEFAULT ''  NOT NULL,
    company          varchar(255)        DEFAULT ''  NOT NULL,
    position         varchar(255)        DEFAULT ''  NOT NULL,
    description      text,
    skype            varchar(255)        DEFAULT '',
    twitter          varchar(255)        DEFAULT '',
    facebook         varchar(255)        DEFAULT '',
    linkedin         varchar(255)        DEFAULT '',
    instagram        varchar(255)        DEFAULT '',
    images           int(11) unsigned    DEFAULT '0' NOT NULL,
    no_profile       tinyint(4)          DEFAULT '0' NOT NULL,
    categories       int(11) unsigned    DEFAULT '0' NOT NULL,
    location         int(11) unsigned    DEFAULT '0' NOT NULL,
    institution_type int(11) unsigned    DEFAULT '0' NOT NULL,
    content_elements int(11) UNSIGNED    DEFAULT '0' NOT NULL,

    sys_language_uid int(11)             DEFAULT '0' NOT NULL,
    l10n_parent      int(11)             DEFAULT '0' NOT NULL,
    l10n_diffsource  mediumblob,

    t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
    t3ver_id         int(11)             DEFAULT '0' NOT NULL,
    t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
    t3ver_label      varchar(30)         DEFAULT ''  NOT NULL,
    t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
    t3ver_stage      tinyint(4)          DEFAULT '0' NOT NULL,
    t3ver_count      int(11)             DEFAULT '0' NOT NULL,
    t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
    t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,
    t3_origuid       int(11)             DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY sys_language_uid_l10n_parent (sys_language_uid, l10n_parent)
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content
(
    tx_cps_author int(11) DEFAULT '0' NOT NULL,
    KEY index_cps_author (tx_cps_author)
);
