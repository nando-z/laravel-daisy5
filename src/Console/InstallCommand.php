<?php

namespace NandoZ\Daisy5\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Termwind\Termwind;
use Figlet\Figlet;

class InstallCommand extends Command
{
    protected $signature = 'daisy5:install';
    protected $description = 'Install DaisyUI 5 with Tailwind CSS 4 For Laravel 11';

    public function handle()
    {
        // Display the FIGlet banner
        $this->displayBanner();

        // Initialize TermWind
        Termwind::renderUsing($this->output);

        // Delete existing Tailwind config
        if (File::exists(base_path('tailwind.config.js'))) {
            File::delete(base_path('tailwind.config.js'));
        }

        // Update package.json
        $this->updateNodePackages();

        // Scaffold files
        $this->scaffoldFiles();

        // Render success message
        $this->renderSuccess('DaisyUI 5 installation complete.');
    }

    /**
     * Display the FIGlet banner using povils/figlet with a background color.
     */
    protected function displayBanner()
    {
        $figlet = new Figlet();
        $this->output->writeln($figlet->render('DaisyUI 5'));
    }

    protected function updateNodePackages()
    {
        $packages = [
            "daisyui" => "^5.0.0",
            "tailwindcss" => "^4.0.0"
        ];

        $this->mergePackageConfig($packages);
    }

    protected function mergePackageConfig($packages)
    {
        $packageJsonPath = base_path('package.json');
        $packageJson = json_decode(file_get_contents($packageJsonPath), true);

        $packageJson['dependencies'] = array_merge(
            $packageJson['dependencies'] ?? [],
            $packages
        );

        file_put_contents(
            $packageJsonPath,
            json_encode($packageJson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
    }

    protected function scaffoldFiles()
    {
        // Scaffold necessary files for DaisyUI and TailwindCSS
        File::put(base_path('tailwind.config.js'), "module.exports = { content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'], theme: { extend: {}, }, plugins: [require('daisyui')], }");
        File::put(base_path('resources/css/app.css'), "@tailwind base; @tailwind components; @tailwind utilities;");
    }

    /**
     * Render a success message using TermWind.
     */
    protected function renderSuccess(string $message)
    {
        $this->output->success($message);
    }

    /**
     * Render an info message using TermWind.
     */
    protected function renderInfo(string $message)
    {
        $this->output->info($message);
    }

    /**
     * Render a comment message using TermWind.
     */
    protected function renderComment(string $message)
    {
        $this->output->comment($message);
    }
}

