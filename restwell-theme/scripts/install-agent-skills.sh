#!/usr/bin/env bash
#
# Install community agent skills (SKILL.md libraries) for Cursor, Codex CLI, and optionally
# other assistants. This matches the bulk of paths used when generating a skills glossary
# (e.g. ~/.cursor/skills, ~/.codex/skills).
#
# Upstream: primarily https://github.com/sickn33/antigravity-awesome-skills (npm: antigravity-awesome-skills)
# Curated index (links only, not a file bundle): https://github.com/VoltAgent/awesome-agent-skills
#
# Not installable from this script (populate separately):
#   - ~/.cursor/skills-cursor — Cursor-managed / manual copies; no single public “clone this” bundle.
#   - ~/.cursor/plugins/cache/... — skills ship with MCP plugins; install plugins in Cursor.
#
# Usage:
#   ./install-agent-skills.sh              # Cursor + Codex (recommended default)
#   ./install-agent-skills.sh --all-tools  # Also Claude Code, Gemini CLI, Antigravity, Kiro
#   ./install-agent-skills.sh --dry-run    # Print the npx command only
#
set -euo pipefail

DRY_RUN=0
ALL_TOOLS=0

usage() {
	sed -n '1,25p' "$0" | tail -n +2
	exit "${1:-0}"
}

while [[ $# -gt 0 ]]; do
	case "$1" in
		-h | --help) usage 0 ;;
		--dry-run) DRY_RUN=1 ;;
		--all-tools) ALL_TOOLS=1 ;;
		*) echo "Unknown option: $1" >&2; usage 1 ;;
	esac
	shift
done

need_cmd() {
	command -v "$1" >/dev/null 2>&1 || {
		echo "Missing required command: $1" >&2
		exit 1
	}
}

need_cmd npx
need_cmd git

NPX=(npx --yes antigravity-awesome-skills)

if [[ "$ALL_TOOLS" -eq 1 ]]; then
	NPX+=(--cursor --codex --claude --gemini --antigravity --kiro)
else
	NPX+=(--cursor --codex)
fi

if [[ "$DRY_RUN" -eq 1 ]]; then
	printf '%q ' "${NPX[@]}"
	echo
	exit 0
fi

echo "Running: ${NPX[*]}"
echo "(This clones/updates a large skill library; first run may take a few minutes.)"
"${NPX[@]}"

echo
echo "Done. Typical locations:"
echo "  Cursor:    ~/.cursor/skills"
echo "  Codex CLI: ~/.codex/skills"
if [[ "$ALL_TOOLS" -eq 1 ]]; then
	echo "  Claude Code: ~/.claude/skills"
	echo "  Gemini CLI:  ~/.gemini/skills"
	echo "  Antigravity: ~/.gemini/antigravity/skills"
	echo "  Kiro CLI:    ~/.kiro/skills"
fi
echo
echo "Optional: open https://github.com/VoltAgent/awesome-agent-skills for the curated index of official/vendor skills (browse links, not a second bulk install)."
