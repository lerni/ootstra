# Prompt Specs

Versioned, refined prompts/specs that drive agent-assisted changes in this
repo. The spec is the artifact of record for *why* a change was made; git
commits are checkpoints of it.

## Layout
- `tasks/` — one file per feature/bugfix, numbered (`NNNN-slug.md`). Refine
  in place as the task evolves. Set `Status: done` when finished, don't delete.
- `system/` — standing conventions/constraints agents should follow across
  tasks (kept separate from `AGENTS.md` only when too task-specific to belong
  there).
- `templates/` — starting point for new task specs.

## Workflow
1. Ideas usually start in `NEXT.md` at the repo root. Copy
   `templates/feature-spec.md` to `tasks/NNNN-slug.md`, fill it in, refine
   as you iterate with the agent, and delete the entry from `NEXT.md`.
   Prefix the task with an underscore, like `_0098-refine-feature.md`, while
   still drafting — those are gitignored. Remove the leading underscore when
   committing, use continuous numbering, and reference it from the commit
   message (see below).
2. Reference it from commits:
   ```
   feat(blocks): add hero block

   Prompt-Spec: .prompts/tasks/0042-add-custom-silverstripe-block.md
   ```
3. When the task is complete, set `Status: done` in the frontmatter/header.
4. `.prompts/` is excluded from deploys via `clear_paths` in `deploy.php` —
   it stays in git history but never ships to test/live.
