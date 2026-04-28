import { defineCollection } from 'astro:content';
import { docsLoader } from '@astrojs/starlight/loaders';
import { docsSchema } from '@astrojs/starlight/schema';
import { z } from 'astro/zod';

export const collections = {
	docs: defineCollection({ loader: docsLoader(), schema: docsSchema() }),
	releases: defineCollection({
		loader: {
			name: 'github-releases-loader',
			load: async ({ parseData, store, renderMarkdown }) => {
				const response = await fetch('https://api.github.com/repos/wrk-flow/php-get-typed-value/releases');
				const data = await response.json();
				
				if (!Array.isArray(data)) {
					console.error('GitHub API response is not an array:', data);
					return;
				}
				
				store.clear();

				for (const release of data) {
					if (!release.id) continue;
					const id = release.id.toString();
					const body = release.body || '';
					const data = {
						title: release.name || release.tag_name,
						tag_name: release.tag_name,
						body,
						published_at: release.published_at,
						html_url: release.html_url,
					};
					
					await parseData({
						id,
						data,
					});

					const rendered = await renderMarkdown(body);

					store.set({
						id,
						data,
						rendered: {
							html: rendered.html,
						},
					});
				}
			},
		},
		schema: z.object({
			title: z.string(),
			tag_name: z.string(),
			body: z.string(),
			published_at: z.string(),
			html_url: z.string(),
		}),
	}),
};
