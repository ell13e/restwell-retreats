#!/usr/bin/env python3
"""One-off: replace Font Awesome class sequences with Phosphor web classes. Run from repo root."""
from __future__ import annotations

from pathlib import Path

THEME = Path(__file__).resolve().parent.parent

# Order matters: longer / more specific first.
REPLACEMENTS: list[tuple[str, str]] = [
    ("fa-solid fa-arrow-up-right-from-square", "ph-bold ph-arrow-square-out"),
    ("fa-solid fa-chevron-right", "ph-bold ph-caret-right"),
    ("fa-solid fa-chevron-down", "ph-bold ph-caret-down"),
    ("fa-solid fa-shield-halved", "ph-bold ph-shield-check"),
    ("fa-solid fa-location-dot", "ph-bold ph-map-pin"),
    ("fa-solid fa-map-location-dot", "ph-bold ph-map-pin"),
    ("fa-solid fa-square-parking", "ph-bold ph-garage"),
    ("fa-solid fa-train-subway", "ph-bold ph-train"),
    ("fa-solid fa-cart-shopping", "ph-bold ph-shopping-cart"),
    ("fa-solid fa-universal-access", "ph-bold ph-wheelchair"),
    ("fa-solid fa-prescription-bottle-medical", "ph-bold ph-pill"),
    ("fa-solid fa-kit-medical", "ph-bold ph-first-aid"),
    ("fa-solid fa-umbrella-beach", "ph-bold ph-umbrella"),
    ("fa-solid fa-bag-shopping", "ph-bold ph-shopping-bag"),
    ("fa-solid fa-person-walking", "ph-bold ph-person-simple-walk"),
    ("fa-solid fa-clipboard-list", "ph-bold ph-clipboard-text"),
    ("fa-solid fa-circle-info", "ph-bold ph-info"),
    ("fa-solid fa-triangle-exclamation", "ph-bold ph-warning"),
    ("fa-solid fa-circle-check", "ph-bold ph-check-circle"),
    ("fa-solid fa-list-check", "ph-bold ph-list-checks"),
    ("fa-regular fa-circle-check", "ph ph-check-circle"),
    ("fa-regular fa-calendar-check", "ph ph-calendar-check"),
    ("fa-regular fa-circle-user", "ph ph-user-circle"),
    ("fa-solid fa-hand-holding-heart", "ph-bold ph-hand-heart"),
    ("fa-solid fa-clipboard-check", "ph-bold ph-clipboard-text"),
    ("fa-solid fa-building-user", "ph-bold ph-buildings"),
    ("fa-solid fa-heart-pulse", "ph-bold ph-heartbeat"),
    ("fa-solid fa-arrow-right", "ph-bold ph-arrow-right"),
    ("fa-solid fa-arrow-left", "ph-bold ph-arrow-left"),
    ("fa-solid fa-check", "ph-bold ph-check"),
    ("fa-solid fa-xmark", "ph-bold ph-x"),
    ("fa-solid fa-plus", "ph-bold ph-plus"),
    ("fa-solid fa-minus", "ph-bold ph-minus"),
    ("fa-solid fa-house", "ph-bold ph-house"),
    ("fa-solid fa-bed", "ph-bold ph-bed"),
    ("fa-solid fa-bath", "ph-bold ph-bathtub"),
    ("fa-solid fa-shower", "ph-bold ph-shower"),
    ("fa-solid fa-heart", "ph-bold ph-heart"),
    ("fa-solid fa-image", "ph-bold ph-image"),
    ("fa-solid fa-images", "ph-bold ph-images"),
    ("fa-solid fa-envelope", "ph-bold ph-envelope-simple"),
    ("fa-solid fa-phone", "ph-bold ph-phone"),
    ("fa-solid fa-print", "ph-bold ph-printer"),
    ("fa-solid fa-file-pdf", "ph-bold ph-file-pdf"),
    ("fa-solid fa-route", "ph-bold ph-path"),
    ("fa-solid fa-pen-nib", "ph-bold ph-pen-nib"),
    ("fa-solid fa-newspaper", "ph-bold ph-newspaper"),
    ("fa-solid fa-key", "ph-bold ph-key"),
    ("fa-solid fa-wifi", "ph-bold ph-wifi-high"),
    ("fa-solid fa-car", "ph-bold ph-car"),
    ("fa-solid fa-gift", "ph-bold ph-gift"),
    ("fa-solid fa-utensils", "ph-bold ph-fork-knife"),
    ("fa-solid fa-seedling", "ph-bold ph-plant"),
    ("fa-solid fa-clock", "ph-bold ph-clock"),
    ("fa-solid fa-water", "ph-bold ph-drop"),
    ("fa-solid fa-anchor", "ph-bold ph-anchor"),
    ("fa-solid fa-store", "ph-bold ph-storefront"),
    ("fa-solid fa-circle-dot", "ph-bold ph-dot"),
    ("fa-solid fa-users", "ph-bold ph-users"),
    ("fa-solid fa-landmark", "ph-bold ph-bank"),
    ("fa-solid fa-wallet", "ph-bold ph-wallet"),
    ("fa-solid fa-sun", "ph-bold ph-sun"),
    ("fa-solid fa-door-open", "ph-bold ph-door-open"),
    ("fa-solid fa-chair", "ph-bold ph-chair"),
    ("fa-solid fa-toilet", "ph-bold ph-toilet"),
    ("fa-solid fa-user-group", "ph-bold ph-users-three"),
    ("fa-solid fa-bus", "ph-bold ph-bus"),
]

SKIP_PARTS = frozenset(
    {
        "node_modules",
        "vendor",
        "assets/css/fontawesome",
        "tools",
    }
)


def should_skip(p: Path) -> bool:
    rel = p.relative_to(THEME)
    return any(part in SKIP_PARTS for part in rel.parts)


def main() -> None:
    exts = {".php", ".js"}
    for path in THEME.rglob("*"):
        if path.suffix not in exts:
            continue
        if should_skip(path):
            continue
        text = path.read_text(encoding="utf-8")
        orig = text
        for old, new in REPLACEMENTS:
            text = text.replace(old, new)
        if text != orig:
            path.write_text(text, encoding="utf-8")
            print(path.relative_to(THEME))


if __name__ == "__main__":
    main()
