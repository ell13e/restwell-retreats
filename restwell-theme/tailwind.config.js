/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        'deep-teal': '#1B4D5C',
        'warm-gold': '#D4A853',
        'soft-sand': '#F5EDE0',
        'sea-glass': '#A8D5D0',
        /** Warm brown — editorial accents, coastal highlights (matches CSS brand usage). */
        brand: '#604c3c',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        serif: ['Lora', 'Georgia', 'serif'],
      },
      /* Align with :root tokens in assets/css/input.css — body 400, emphasis 500, UI/labels 600 */
      fontWeight: {
        body: '400',
        emphasis: '500',
        label: '600',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
};
