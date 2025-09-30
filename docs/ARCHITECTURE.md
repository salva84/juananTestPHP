Architecture

Goals
- High-quality OOP design, maintainable and testable
- Clear separation of concerns using a layered (clean) architecture
- Robust i18n and Unicode support
- Simple to deploy on standard LAMP stacks

Layers
1) Domain
   - Entities: Accommodation (abstract), Hotel, Apartment
   - Value Objects: Location, RoomType (enum), AccommodationType (enum)
   - Repository Ports: AccommodationRepository (interface)

2) Application
   - Use cases (services): SearchAccommodationsService
   - Input: first three letters (prefix), locale
   - Output: list of localized display strings sorted by name

3) Infrastructure
   - Persistence: PdoAccommodationRepository (implements AccommodationRepository)
   - i18n: Translator loads JSON catalogs per locale
   - CLI: bin/search.php wiring, STDIN/STDOUT handling

Data flow (CLI)
User -> CLI (bin/search.php) -> SearchAccommodationsService -> AccommodationRepository -> MySQL
                                                                        ^
                                                                        |
                                                           Translator (i18n)

Database model
- Table accommodation: id, type (hotel|apartment), name, city, province
- Table hotel_details: accommodation_id, stars, standard_room_type
- Table apartment_details: accommodation_id, num_units, capacity_adults

Sorting policy
- Sort by accommodation name (CASE- and accent-insensitive where possible). Use a suitable collation in MySQL (utf8mb4_unicode_ci) and ORDER BY name.

Internationalization
- Output uses translation catalogs keyed by locale (en, es, ar, zh, ...)
- Data labels such as "stars", "apartments", "adults", and room type names are localized
- RTL languages supported by rendering labels appropriately; terminal direction is left as-is

Error handling
- Domain/Application: use exceptions for unrecoverable errors and return empty results for no matches
- Infrastructure: convert PDO errors to domain exceptions with meaningful messages

Performance considerations
- Index on accommodation(name) for prefix searches
- LIMIT results (configurable) to avoid excessive output
- Stream results to STDOUT instead of accumulating large arrays when necessary

Security considerations
- Use prepared statements; never interpolate user input directly into SQL
- Do not log raw credentials; keep them in config/config.php (not committed with real secrets)

Diagrams
See docs/uml/domain-class-diagram.puml and docs/uml/request-sequence.puml


