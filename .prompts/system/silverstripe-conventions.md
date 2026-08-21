# System Constraints for Prompt Specs

Full project conventions live in `AGENTS.md` — read that first. This file only
adds constraints specific to writing/executing prompt specs:

- Never reference `.prompts/` paths from application code or templates — it's
  a dev-only artifact, stripped from deploys via `clear_paths`.
- Prefer linking back to an existing task spec over duplicating context when
  a follow-up prompt continues earlier work.
