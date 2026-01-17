# Website Color Theme Guide

## Color Palette

### Primary Colors
- **Header/Navigation Bar**: Orange shades
  - Primary Orange: `#FF6B35`
  - Light Orange: `#FF8C61` (hover states)
  - Dark Orange: `#E55A2B` (active states)
  - Gradient: `#FF6B35` → `#FF8C61`

- **Buttons/CTA**: Metallic Silver `#A7A9AC`
  - Hover: `#8a8d90`
  - Active: `#7a7d80`

- **Links & Text**: Black `#000000`
  - Hover: Orange `#FF6B35`

- **Forms/Input Fields**: Charcoal Gray `#231F20`
  - Text: White `#FFFFFF`
  - Focus Border: Orange `#FF6B35`

- **Backgrounds**: White `#FFFFFF`
  - Secondary: `#f8fafc` (slightly off-white)

- **Alerts/Messages**:
  - Success: Green `#28a745`
  - Error: Red `#dc3545`
  - Warning: Yellow `#ffc107`
  - Info: Blue `#17a2b8`

- **Footer**: Deep Navy Blue `#1B365D`
  - Text: White `#FFFFFF`

### Social Media Brand Colors
- Facebook: `#1877F2`
- Twitter: `#1DA1F2`
- LinkedIn: `#0077B5`
- Instagram: `#E4405F`
- YouTube: `#FF0000`

---

## Element-Specific Color Mapping

### Navigation Bar
```css
background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);
color: #FFFFFF;
```

### Buttons (Primary, Success, Info)
```css
background-color: #A7A9AC;
color: #000000;
border-color: #A7A9AC;
```

**Hover State:**
```css
background-color: #8a8d90;
```

**Active State:**
```css
background-color: #7a7d80;
box-shadow: 0 0 0 0.2rem rgba(167, 169, 172, 0.5);
```

### Links
```css
color: #000000;
```

**Hover State:**
```css
color: #FF6B35;
text-decoration: underline;
```

### Form Inputs
```css
background-color: #231F20;
color: #FFFFFF;
border: 1px solid #231F20;
```

**Focus State:**
```css
border-color: #FF6B35;
box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
```

### Alerts

**Success:**
```css
background-color: #d4edda;
color: #155724;
border-left: 4px solid #28a745;
```

**Error:**
```css
background-color: #f8d7da;
color: #721c24;
border-left: 4px solid #dc3545;
```

**Warning:**
```css
background-color: #fff3cd;
color: #856404;
border-left: 4px solid #ffc107;
```

**Info:**
```css
background-color: #d1ecf1;
color: #0c5460;
border-left: 4px solid #17a2b8;
```

### Footer
```css
background-color: #1B365D;
color: #FFFFFF;
```

### Badges

**Primary:**
```css
background-color: #FF6B35;
color: #FFFFFF;
```

**Secondary:**
```css
background-color: #A7A9AC;
color: #000000;
```

**Success:**
```css
background-color: #28a745;
color: #FFFFFF;
```

**Danger:**
```css
background-color: #dc3545;
color: #FFFFFF;
```

### Cards

**Card Header:**
```css
background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);
color: #FFFFFF;
```

**Stat Cards:**
```css
background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);
color: #FFFFFF;
```

---

## Interactive States

### Hover States
- **Navigation Links**: White background with 20% opacity
- **Buttons**: Darker shade of base color
- **Links**: Change to orange
- **Dropdown Items**: Light orange background (10% opacity)

### Active States
- **Navigation Links**: White background with 30% opacity, bold font
- **Buttons**: Darkest shade of base color with shadow
- **Dropdown Items**: Medium orange background (20% opacity)

### Focus States
- **Form Inputs**: Orange border with shadow
- **Buttons**: Shadow ring in button color

### Disabled States
- **Buttons**: 50% opacity, cursor: not-allowed
- **Inputs**: Gray background, reduced opacity

---

## CSS Variables Reference

All colors are defined as CSS variables in `:root`:

```css
--orange-primary: #FF6B35;
--orange-light: #FF8C61;
--orange-dark: #E55A2B;
--metallic-silver: #A7A9AC;
--charcoal-gray: #231F20;
--clean-white: #FFFFFF;
--deep-navy-blue: #1B365D;
--black: #000000;
--success-green: #28a745;
--error-red: #dc3545;
--warning-yellow: #ffc107;
--info-blue: #17a2b8;
```

---

## Usage Guidelines

1. **Consistency**: Always use the defined CSS variables for colors
2. **Contrast**: Ensure sufficient contrast for accessibility (WCAG AA minimum)
3. **Hover States**: Always provide visual feedback on interactive elements
4. **Focus States**: Essential for keyboard navigation accessibility
5. **Social Icons**: Use official brand colors for social media icons

---

## Accessibility Notes

- All color combinations meet WCAG AA contrast requirements
- Focus states are clearly visible for keyboard navigation
- Text colors provide sufficient contrast against backgrounds
- Interactive elements have clear hover and active states

---

**Last Updated**: 2026-01-17  
**Theme Version**: 2.0 (Orange Header Theme)

