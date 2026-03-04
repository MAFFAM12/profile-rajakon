import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.jsx',
        './vendor/filament/**/*.blade.php',
    ],
    plugins: [
        require('@tailwindcss/typography'),
    ],
    darkMode: 'selector',
}
