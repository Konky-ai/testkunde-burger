# Project Overview
Create a mobile-first, single-page website for a modern Neapolitan pizza restaurant. The goal is maximum conversion and a perfect user experience on smartphones. The design should feel like a premium native app.

# Tech Stack
- HTML5
- Tailwind CSS (via CDN for simplicity)
- Vanilla JavaScript (for minimal logic and smooth scrolling)
- FontAwesome (via CDN for icons)

# Design System & Vibe
- **Approach:** Mobile-first and fully responsive. The design must prioritize a flawless, native-app-like experience on mobile devices. However, there is **no strict max-width**. The layout must adapt fluidly and scale intelligently across all viewports (mobile, tablet/iPad, and large desktop screens), ensuring optimal readability, spacing, and user experience on every device.
- **Colors:** Light, modern theme (e.g., soft off-white or warm cream background, deep charcoal or dark espresso text for high readability, and a vibrant terracotta-red or warm pizza-crust gold for buttons and accents).
- **Typography:** Clean, sans-serif font (e.g., Inter or Roboto) mixed with a bold, slightly rustic font for headers.

# Page Structure (Single Page)

## 1. Navbar
A floating, pill-shaped navigation bar that is horizontally centered and fixed to the top edge of the screen (`position: fixed`).

* **Morphing Logic (via IntersectionObserver or ScrollTrigger):** * *Hero Section:* Transparent with light font color to blend seamlessly into the darker background image.
    * *On Scroll (Instant):* Transition to a semi-transparent background (`bg-[#FAF9F6]/60`), a strong blur effect (`backdrop-blur-xl`), text in the primary color/anthracite, and a very subtle, light border (`border`).
* **Content (Left to Right):** * Logo (Restaurant name as a typographic element). Must be clickable and bring the user back home (smooth scrolls to the top of the site). 
    * Right: "Reservierung" (smooth scrolls to `#reservation`). Should be visible on all screen sizes.
    * Far Right/End: CTA Button "Menü" (in the accent color Terracotta).(smooth scrolls to `#menu`). 

## 2. Hero Section (Above the Fold)

- **Layout & Spacing:** The entire content block must be perfectly vertically and horizontally centered within the viewport (`100vh`). Ensure plenty of negative space at the top and bottom edges so absolutely nothing sticks to the borders of the screen.
- **Background:** A high-quality, slightly darkened image of a perfect Neapolitan pizza. Generate your own realistic placeholder image for the Hero background.
- **Content Order (Top to Bottom, Centered):**
  1. **H1:** Restaurant Name ("Pizza Napoli") (Very large, bold, highly emphasized. Placed directly over the background).
  2. **P:** A short, punchy Slogan (e.g., "48h Teigruhe. 100% Neapel in Berlin.").
  3. **Primary CTA:** A large, prominent button saying "Zur Speisekarte" (Background: Terracotta `#E2725B`, Text: White, smooth scrolls to `#menu`).
  4. **Compact Quick-Facts (Inside a Transparent Shell):** - **Container Style:** Create a glassmorphism container (`bg-white/10`, `backdrop-blur-xl`, `border border-white/20`, `rounded-[24px]`, `shadow-[0_8px_32px_rgba(0,0,0,0.15)]`). Include a soft hover state (`hover:bg-white/15` with a 300ms transition) and sensible padding (`p-5 sm:p-7`). The width should be flexible (`w-auto sm:min-w-[300px] max-w-full`). Center the container itself, but keep the text left-aligned.
    - **Positioning:** Add a top margin (`mt-8`) so it sits directly underneath the "Zur Speisekarte" button. It must remain in the normal document flow and should **not** be fixed to the bottom of the screen.
    - **Content (Stacked cleanly inside the shell with `flex-col`, `gap-3`):** All text elements should be white, while all icons should have a fixed width of `w-5`, be centered, and use the `text-terracotta` color.
      - `[FontAwesome: fa-regular fa-clock]` Heute: `<span id="hero-dynamic-hours" class="font-bold">...</span>`
      - `[FontAwesome: fa-regular fa-credit-card]` Bar & Kartenzahlung
      - **Divider:** Add a subtle top border (`border-t border-white/20 pt-3 mt-1`) before the reservation item.
      - `[FontAwesome: fa-regular fa-calendar]` **[Clickable Text: "Hier reservieren"]** (Must be an `<a>` tag pointing to `#reservation`. Make it bold `text-terracotta`, with an underline decoration matching the text color that transitions to white on hover with an underline-offset of 4).

## 3. Atmosphere Section — "Sticky Crossfade Experience"

**Technique & Interaction:** A fluid, scroll-based transition (controlled via React and `framer-motion`) where the container is pinned to the screen (`sticky`) while the user scrolls through a defined height (470vh in total).
- **Background Animation:** The background images smoothly scale from `1.08` to `1` (a subtle zoom-out effect) and softly crossfade into one another (opacity) as the user scrolls.
- **Text Animation:** The text appears with a slight delay. Upon entering, it moves smoothly along the Y-axis (from `40px` to `0`, then exiting to `-40px`) and fades out when the next section begins.
- **Styling:** Dark, atmospheric overlays (`bg-black/50` with vignette gradients), serif typography for the headings, and elegant, small badges.

**Content (The 3 Phases):**

**Phase 1**
* **Badge:** 01 — Das Ambiente
* **Image:** `Atmosphere Image 1` (warmes Licht, glühender Steinofen im Hintergrund)
* **Title:** Die Atmosphäre
* **Description:** "Das warme Leuchten unseres Ofens, gemütliches Beisammensein und der unwiderstehliche Duft nach gebackenem Teig. Ein Ort, der sich anfühlt wie ein Abend bei guten Freunden."

**Phase 2**
* **Badge:** 02 — Die Essenz
* **Image:** `Atmosphere Image 2` (Teigzubereitung, frische Tomaten und Basilikum)
* **Title:** Die Zutaten
* **Description:** "Großer Geschmack braucht Zeit. Unser Teig ruht schonend für 48 Stunden, bevor er mit sonnengereiften San-Marzano-Tomaten und feinstem Fior di Latte verschmilzt."

**Phase 3**
* **Badge:** 03 — Das Handwerk
* **Image:** `Atmosphere Image 3` (Pizzaiolo am heißen Ofen, eine Pizza mit luftigem Rand)
* **Title:** Das Feuer
* **Description:** "Bei über 400 Grad wird Tradition lebendig. Unsere Pizzaioli beherrschen das Spiel mit der Hitze und sorgen bei jeder Pizza für den perfekten, krossen Rand mit dem typischen Leopardenmuster."


## 4. Opening Hours Section (ID: #hours)
- **Placement:** Immediately following the Hero Section.
- **Design:** Minimalist and highly functional.
- **Layout:** A clean, two-column list. Left column: Days of the week (Montag to Sonntag) listed vertically. Right column: The corresponding opening hours aligned to the right.
- **Dynamic Logic (JavaScript):**
  - Automatically detect the current day of the week.
  - Visually highlight the current day by making its text larger and **bold**.
  - If the restaurant is closed on the current day, the text "Geschlossen" must be prominently displayed in red to provide immediate clarity.

## 5. Menu Section (ID: #menu)

- **Layout & Spacing:** A centered layout with generous top and bottom padding. The main menu content is housed inside a prominent, unified card container with large rounded corners and a soft shadow, creating an elevated, clean look.
- **Section Header (Top, Centered):**
  - **Overline:** Small, uppercase sans-serif text with wide letter spacing (e.g., "OUR OFFERINGS").
  - **H2:** Main section title (e.g., "The Menu"), using large, elegant, lightweight serif typography.
- **Interactive Accordion Logic:**
  - The menu is divided into distinct categories (e.g., Appetizers & Starters, Main Courses, Desserts).
  - Clicking a category header smoothly expands its content panel (`height: auto`, fading in) and rotates a Chevron icon 180 degrees.
  - *UX Detail:* Only one category remains open at a time. Opening a new category automatically closes the previously opened one to keep the interface tidy.
- **Category Header Structure:**
  - Large serif typography for the category name.
  - A circular toggle icon on the far right containing a Chevron.
  - A subtle bottom border separates each category (the final category has no bottom border).
- **Menu Item Structure (Inside expanded categories):**
  - **Responsive Layout (Mobile-First):**
    - *Mobile:* The item name and price sit together on the top line, with the ingredients wrapping underneath.
    - *Desktop/Tablet:* The item name and ingredients are grouped on the left, while the price is pushed cleanly to the far right edge of the container.
  - **Item Name:** Medium-sized serif typography.
  - **Ingredients:** Smaller, easily readable sans-serif text placed directly below the item name.
  - **Price:** Small, sans-serif text with wide letter spacing (tracking) for a refined, modern aesthetic.


## 6. Reservation Section (ID: #reservation)
- A simple, clean section with a brief text: "Reserviere deinen Tisch bei uns."
- Include a placeholder button saying "Tisch online reservieren" (which could later link to an external booking system).

## 7. Footer (ID: #location)
- **Location & Contact:** "Musterstraße 123, 10115 Berlin" (clickable Google Maps link) and "030-1234567" (clickable `tel:` link).
- **Map:** Embed a simple Google Maps iframe.
- **Socials & Legal:** Icons for Instagram and TikTok. Simple text links for "Impressum" and "Datenschutz".

# Logic & Interactivity (JavaScript)
1. **Dynamic Opening Hours (Hero & List):** Write a script that checks the current day of the week. It needs to:
   - Inject today's hours into the `#hero-dynamic-hours` span in the Hero section.
   - Apply the bold/larger styling to today's row in the Opening Hours table.
   - Apply red text if today is a closed day ("Geschlossen").
2. **Smooth Scrolling:** Ensure all anchor links (navigation, hero buttons, home button) use smooth scrolling behavior.
3. **Sticky Header Transition:** Write a script to detect scroll position and add/remove a solid background class to the header.
4. **Accordion Logic:** Write the JS to toggle the open/close state of the menu categories.

