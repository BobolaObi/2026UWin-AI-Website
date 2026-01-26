# Wicked Compressor — Development Guidelines

## AI Assistance
- Never paste secrets, usernames, or identifiable paths into prompts.
- Ask AI for small, isolated changes; never full rewrites unless intended.
- Review generated code before committing.
- Inspect shell commands for safety before running.
- Always verify output locally after using AI to generate code.

## Python Style
- Follow PEP 8.
- Use `snake_case` for variables/functions, `UPPER_SNAKE_CASE` for constants.
- Use clear names (`input_path`, `output_file`, `crf_value`).
- No magic numbers — define constants at the top.
- Keep functions single-purpose and short. Extract helpers instead of nesting.
- Add type hints when they increase clarity.
- Error handling must give a clear message; never swallow exceptions silently.

## Comments & Documentation
- Write concise comments only when intent is non-obvious; remove or update stale notes. e.g Comment *why*, not what.
- Keep comments minimal and accurate; remove outdated ones.
- Update Markdown docs when a feature changes or when new behavior is introduced.
- Ensure instructions match actual user flow.

## Commit Messages (Conventional Commits)

- Format: `<type>(scope): summary` using an imperative, no trailing period.
- Common types: feat (new behavior), fix (bug), docs (docs only), refactor (internal change), test (tests only), chore (infra/cleanup).
- Scope is optional but encouraged (e.g., `feat(cli): add bitrate flag`).
- Use the body for rationale, side effects, and issue references when relevant.

- Types:
- `feat` — new behavior or capability  
- `fix` — bug fix  
- `docs` — documentation only  
- `refactor` — internal cleanup, no behavior change  
- `perf` — performance improvements  
- `test` — tests only  
- `chore` — maintenance, tooling, configs  

## Versioning (manifest.json)

- After every `feat` or `fix` is successfully committed, the version in `manifest.json` must be incremented.
- This is done as a separate `chore(manifest)` commit.
- Follow Semantic Versioning (MAJOR.MINOR.PATCH):
  - **PATCH** (`1.0.x`): For backward-compatible bug fixes (`fix`) or small features (`feat`).
  - **MINOR** (`1.x.0`): For new functionality added in a backward-compatible manner.
  - **MAJOR** (`x.0.0`): For breaking changes.
- For this project, we will primarily increment the **PATCH** version for each change.

## Code Workflow
1. Create a feature branch.
2. Make focused changes (one concern per PR).
3. Test locally when possible.
4. Ensure docs match behavior.
5. Use a clean Conventional Commit message.
6. Merge after confirming output is correct.

## Testing Checklist
- Folder drag-and-drop works.
- Single file compression works.
- Handles paths with spaces and special chars.
- Detects when no video is present.
- Handles FFmpeg permission/availability errors.
- Output file is created as `New <original>.mp4`.
- CRF setting changes behave correctly.

## Rules:
- Use an imperative: “add”, “fix”, “update”, not past tense.
- Keep the summary short.
- Use body text when rationale or impact needs explanation
  
## Philosophy
Minimal code. Predictable behavior.  
Fast feedback. No surprises.  
Always protect the user’s original files.

## Brand & UI Constraints
- Use University of Windsor / Lancer palette (UWindsor Blue #005596, Gold #FFCE00, Grey #58595B, Lancer Navy #0E1B2A). Logos should sit on solid backgrounds with white type when needed for contrast.
- No gradients in backgrounds or components; default to solid white backgrounds unless explicitly specified.
