const fs = require('fs');
const path = require('path');

const docsPath = path.join(__dirname, 'src/content/docs');
const outputPath = path.join(__dirname, 'public/llms.txt');

const files = [
    'introduction.md',
    'guides/validation.md',
    'guides/transformers.md',
    'guides/laravel.md',
    'guides/customization/custom-data-holder.md',
    'guides/customization/custom-exceptions.md',
];

let content = "# php-get-typed-value\n\n";
content += "> Get typed (strict mode) values from an Array / XML with basic validation.\n\n";

for (const file of files) {
    const filePath = path.join(docsPath, file);
    if (fs.existsSync(filePath)) {
        let fileContent = fs.readFileSync(filePath, 'utf8');

        // Remove frontmatter
        fileContent = fileContent.replace(/^---[\s\S]*?---/s, '');

        // Remove html tags (badges)
        fileContent = fileContent.replace(/<img[^>]*>/gi, '');

        const fileName = path.basename(file, '.md');
        const title = fileName.charAt(0).toUpperCase() + fileName.slice(1).replace(/-/g, ' ');

        content += `## ${title}\n\n`;
        content += fileContent.trim() + "\n\n";
    } else {
        console.warn(`File not found: ${filePath}`);
    }
}

if (!fs.existsSync(path.dirname(outputPath))) {
    fs.mkdirSync(path.dirname(outputPath), { recursive: true });
}

fs.writeFileSync(outputPath, content);
console.log(`llms.txt generated at ${outputPath}`);
