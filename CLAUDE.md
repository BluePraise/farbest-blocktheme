# Farbest Block Theme

Active WordPress FSE (Full Site Editing) theme — the target for all ongoing theme development.
Replaces `theme/farbest` (classic theme, reference only).

## Architecture
- **WordPress**: 6.9+ (FSE / block themes)
- **Templates**: `templates/` — HTML block templates (index, page, single, archive, etc.)
- **Parts**: `parts/` — reusable template parts (header, footer, footer-wave)
- **Patterns**: `patterns/` — PHP-registered block patterns (hero, card-grid, cta-button, benefits-columns)
- **Styles**: `css/` — `tokens.css` (design tokens), `global.css`, `header.css`, `footer.css`, `card-grid.css`, `ingredient-single.css`
- **theme.json**: canonical source for colors, typography, spacing, and layout constraints

## Brand Colors
| Name | Hex | Slug |
|---|---|---|
| Primary Green | `#648c1c` | `green` |
| Dark Teal | `#003e52` | `teal` |
| CTA Lime | `#b5b800` | `lime` |
| Heading Green | `#4D7B29` | `heading-green` |
| Beige bg | `#f2efe9` | `beige` |
| Warm Grey | `#383838` | `warm-grey` |

All colors are defined in `theme.json` — do not hardcode hex values in CSS. Use `var(--wp--preset--color--{slug})`.

## Layout
- Content width: `780px`
- Wide width: `1200px`

## Custom Blocks (PHP-registered)
- `farbest/hamburger-button` — mobile nav toggle, registered in `functions.php`
- `farbest/card-grid` — card grid block, registered via `inc/card-grid-block.php`

## Patterns
- `farbest/hero` — full-width hero, teal background
- `farbest/card-grid` — card grid layout
- `farbest/cta-button` — lime CTA button
- `farbest/benefits-columns` — two-column application benefits layout for `fpc_ingredient` pages (see below)
- `farbest/benefits-column-single` — single-column variant of the above, for ingredients with only one benefits group

## Plugin Integration
This theme works alongside `plugins/farbest-product-catalog`. Ingredient archive/single templates are owned by the plugin — do not duplicate them in the theme.

## Ingredient Single Page — Benefits Columns

### Decision (June 2026)
The `benefits_columns` ACF repeater field and its PHP rendering logic in `single-ingredient.php` have been **removed**. The client edits benefits infrequently, so the overhead of ACF maintenance wasn't justified.

**Replacement:** `patterns/benefits-columns.php` — a block pattern restricted to `fpc_ingredient` post types via `Post Types: fpc_ingredient` in the pattern header. The client inserts it from the block inserter and edits content inline.

### Pattern: `farbest/benefits-columns`
- File: `patterns/benefits-column.php`
- Two `wp:column` blocks inside `wp:columns`, each with a `wp:heading` (h3) and `wp:list`
- Locked with `templateLock: contentOnly` — client can edit text and list items but cannot alter the two-column structure
- CSS: `.farbest-benefits-columns` and child classes in `css/ingredient-single.css`
- **Note:** Test `contentOnly` locking on staging — WP can ignore it when a pattern is inserted into post content rather than a template. If the lock doesn't hold, remove it and rely on client training.

### Pattern: `farbest/benefits-column-single`
- File: `patterns/benefits-column-single.php`
- Same structure as `benefits-columns` but with a single `wp:column` — for ingredients with only one benefits group
- Reuses `.farbest-benefits-columns` and child classes, so no extra CSS needed
- Client picks whichever pattern (one- or two-column) fits the ingredient when inserting

### What to remove from `single-ingredient.php` (plugin)
The following are no longer needed and should be cleaned up when convenient:
- `$benefits_columns = get_field('benefits_columns')` and all `$all_benefits_columns` logic
- The auto-merge loop that injected synthetic Application/Fiber columns
- The `$has_app_column` / `$has_fiber_column` flags

The `fpc_application` and `fpc_fiber_benefit` taxonomy terms still exist and still display in the **Product Details tab** — that is unaffected.

## Key Notes
- Add new page layouts as block templates in `templates/` or patterns in `patterns/`
- CSS design tokens live in `css/tokens.css` — keep token definitions there, not in `theme.json` custom properties
- The classic theme (`theme/farbest`) is the reference for any content or styles that haven't been migrated yet