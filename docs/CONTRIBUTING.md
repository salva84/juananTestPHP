Contributing & Coding Standards

Code style
- PHP >= 8.1, strict_types=1
- OOP-first: entities/value objects with clear responsibilities
- Names are explicit and meaningful; avoid abbreviations
- Prefer early returns and shallow nesting
- Handle errors explicitly; avoid swallowing exceptions

Architecture
- Follow the documented layers (Domain, Application, Infrastructure)
- Domain models must be pure and framework-agnostic
- Application services orchestrate domain and infrastructure
- Infrastructure implements ports (repositories, translators)

Security
- Use prepared statements; never concatenate SQL with user input
- Keep credentials out of code; use config/config.php (local only)

Testing
- Write PHPUnit tests for new behavior
- Unit tests for domain; integration for repositories

Commits
- Follow Conventional Commits (https://www.conventionalcommits.org/):
  - feat: add a new feature
  - fix: bug fix
  - docs: documentation only changes
  - refactor: code change that neither fixes a bug nor adds a feature
  - test: adding or correcting tests
  - chore: maintenance tasks
  - perf: performance improvements
- Scope examples: domain, app, infra, db, i18n, cli
  - feat(domain): add RoomType enum
  - fix(infra): correct PDO DSN handling

Branches & PRs
- main is stable; feature branches follow: feature/<short-name>
- Small, focused PRs with clear descriptions and tests


