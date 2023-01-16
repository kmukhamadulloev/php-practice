CREATE TABLE xml_offers(
  id INT NOT NULL,
  mark VARCHAR(40),
  model VARCHAR(40),
  generation VARCHAR(40),
  model_year YEAR,
  run INT DEFAULT 0,
  color VARCHAR(40),
  body_type VARCHAR(40),
  engine_type VARCHAR(40),
  transmission VARCHAR(40),
  gear_type VARCHAR(40),
  generation_id INT NOT NULL
)