<?php

namespace NandoZ\Daisy5\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Termwind\Termwind;

class InstallCommand extends Command
{
    protected $signature = 'daisy5:install';
    protected $description = 'Install DaisyUI 5 with Tailwind CSS 4 and TermWind';

    public function handle()
    {
        // Initialize TermWind
        Termwind::renderUsing($this->output);

        // Delete existing Tailwind config
        if (File::exists(base_path('tailwind.config.js'))) {
            File::delete(base_path('tailwind.config.js'));
            $this->renderSuccess('Deleted existing tailwind.config.js');
        }

        // Update package.json
        $this->updateNodePackages();
        $this->renderSuccess('Updated package.json with required dependencies');

        // Scaffold files
        $this->scaffoldFiles();
        $this->renderSuccess('Scaffolded app.css and vite.config.js');

        // Final message
        $this->renderInfo('Daisy5 installed successfully!');
        $this->renderComment('Run: npm install && npm run build');
    }

    protected function updateNodePackages()
    {
        $packages = [
            'tailwindcss' => '^4.0.0',
            '@tailwindcss/vite' => '^0.2.0',
            '@tailwindcss/postcss' => '^0.0.0',
            'postcss' => '^8.4.0',
            'daisyui' => '^5.0.0'
        ];

        File::put(
            base_path('package.json'),
            json_encode($this->mergePackageConfig($packages), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    protected function mergePackageConfig($packages)
    {
        $packageJson = File::exists(base_path('package.json'))
            ? json_decode(File::get(base_path('package.json')), true)
            : ['devDependencies' => []];

        return array_merge_recursive($packageJson, [
            'devDependencies' => $packages
        ]);
    }

    protected function scaffoldFiles()
    {
        File::ensureDirectoryExists(resource_path('css'));
        File::copy(__DIR__.'/../../../resources/stubs/app.css', resource_path('css/app.css'));
        File::copy(__DIR__.'/../../../resources/stubs/vite.config.js', base_path('vite.config.js'));
    }

    /**
     * Render a success message using TermWind.
     */
    protected function renderSuccess(string $message)
    {
        Termwind::render(<<<HTML
            <div class="px-2 py-1 bg-green-600 text-white">✔ {$message}</div>
        HTML);
    }

    /**
     * Render an info message using TermWind.
     */
    protected function renderInfo(string $message)
    {
        Termwind::render(<<<HTML
            <div class="px-2 py-1 bg-blue-600 text-white">ℹ {$message}</div>
        HTML);
    }

    /**
     * Render a comment message using TermWind.
     */
    protected function renderComment(string $message)
    {
        Termwind::render(<<<HTML
            <div class="px-2 py-1 bg-yellow-600 text-white">➤ {$message}</div>
        HTML);
    }
}