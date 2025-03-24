-- insert into provinces

INSERT INTO provinces (kode, nama, deleted_at, created_at, updated_at)

SELECT
    kode,
    nama,
    null,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM wilayah WHERE CHAR_LENGTH(kode) = 2;


-- insert into cities

INSERT INTO cities (kode,province_kode, nama, deleted_at, created_at, updated_at)

SELECT
    kode,
    LEFT(kode, 2) AS provinces_kode,
    nama,
    null,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM wilayah WHERE CHAR_LENGTH(kode) = 5;

-- insert into subdistricts

INSERT INTO subdistricts (kode, city_kode, nama, deleted_at, created_at, updated_at)

SELECT
    kode,
    LEFT(kode, 5) AS city_kode,
    nama,
    null,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM wilayah WHERE CHAR_LENGTH(kode) = 8;

-- insert into villages

INSERT INTO villages (kode, subdistrict_kode, nama, deleted_at, created_at, updated_at)

SELECT
    kode,
    LEFT(kode, 8) AS subdistrict_kode,
    nama,
    null,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
FROM wilayah WHERE CHAR_LENGTH(kode) = 13;
