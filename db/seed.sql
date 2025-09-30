-- Seed sample data with multilingual names
USE accommodations;

-- Hotels
INSERT INTO accommodation (type, name, city, province)
VALUES
  ('hotel', 'Hotel Azul', 'Valencia', 'Valencia'),
  ('hotel', 'Hotel Blanco', 'Mojacar', 'Almeria'),
  ('hotel', 'Hotel Rojo', 'Sanlucar', 'Cádiz'),
  ('hotel', 'فندق النور', 'دبي', 'دبي'),
  ('hotel', '酒店青', '上海', '上海');

INSERT INTO hotel_details (accommodation_id, stars, standard_room_type)
SELECT id, stars, room FROM (
  SELECT a.id, 3 AS stars, 'double_view' AS room FROM accommodation a WHERE a.name = 'Hotel Azul'
  UNION ALL
  SELECT a.id, 4, 'double' FROM accommodation a WHERE a.name = 'Hotel Blanco'
  UNION ALL
  SELECT a.id, 3, 'single' FROM accommodation a WHERE a.name = 'Hotel Rojo'
  UNION ALL
  SELECT a.id, 5, 'suite' FROM accommodation a WHERE a.name = 'فندق النور'
  UNION ALL
  SELECT a.id, 4, 'family' FROM accommodation a WHERE a.name = '酒店青'
) t JOIN accommodation a2 ON a2.id = t.id;

-- Apartments
INSERT INTO accommodation (type, name, city, province)
VALUES
  ('apartment', 'Apartamentos Beach', 'Almeria', 'Almeria'),
  ('apartment', 'Apartamentos Sol y playa', 'Málaga', 'Málaga'),
  ('apartment', 'شقق الواحة', 'مسقط', 'مسقط'),
  ('apartment', '公寓海滩', '三亚', '海南');

INSERT INTO apartment_details (accommodation_id, num_units, capacity_adults)
SELECT id, units, cap FROM (
  SELECT a.id, 10 AS units, 4 AS cap FROM accommodation a WHERE a.name = 'Apartamentos Beach'
  UNION ALL
  SELECT a.id, 50, 6 FROM accommodation a WHERE a.name = 'Apartamentos Sol y playa'
  UNION ALL
  SELECT a.id, 15, 4 FROM accommodation a WHERE a.name = 'شقق الواحة'
  UNION ALL
  SELECT a.id, 20, 3 FROM accommodation a WHERE a.name = '公寓海滩'
) t JOIN accommodation a2 ON a2.id = t.id;


