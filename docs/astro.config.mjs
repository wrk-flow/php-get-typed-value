// @ts-check
import { defineConfig } from 'astro/config';
import starlight from '@astrojs/starlight';

// https://astro.build/config
export default defineConfig({
	integrations: [
		starlight({
			title: 'php-get-typed-value',
			social: [{ icon: 'github', label: 'GitHub', href: 'https://github.com/wrk-flow/php-get-typed-value' }],
			sidebar: [
				{
					label: 'Introduction',
					slug: 'introduction',
				},
				{
					label: 'Guides',
					autogenerate: { directory: 'guides' },
				},
				{
					label: 'Customization',
					autogenerate: { directory: 'customization' },
				},
				{
					label: 'Releases',
					link: '/releases/',
				},
				{
					label: 'llms.txt',
					link: '/llms.txt',
				},
			],
			customCss: [
				// Relative path to your custom CSS file
				'./src/styles/custom.css',
			],
			credits: true
		}),
	],
});
