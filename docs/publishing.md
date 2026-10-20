# Building and publishing the documentation

`phpdoc.dist.xml` builds the API reference from `src/` and Markdown guides from
`docs/`. Only the generated `build/` directory is published. No credentials,
client JSON, source dependencies or private evidence trees belong in that output.

The existing DiscordPHP-family phpDocumentor toolchain is pinned in the workflow
to `40e5911a592e5fc4407096cebd5fb4aaf2e9df6f`, with its own committed Composer lock
and reviewed nullable-type patches. Its Composer patch plugin is intentional;
the uploader consumer's no-plugin installation policy is a different project.
Graphviz `dot` and local PlantUML must be installed for the generated class diagram.
Set `PHPDOC_PLANTUML=plantuml` and `PHPDOC_PLANTUML_BIN` to the local PlantUML
executable (CI uses `/usr/bin/plantuml`). The Composer distribution does not bundle
the binary assumed by its default renderer. No remote diagram service is used.
The configuration
also explicitly sets `graphs.enabled=true`; phpDocumentor disables graph rendering
by default even though its default template emits a diagram-page link.

For a local build, install that toolchain in `phpdoc-tool/` as its own project,
or point `PHPDOC` at an existing trusted toolchain's `vendor/bin/phpdoc`. Then run:

```bash
php tools/build-docs.php
php tools/check-docs.php
php -S 127.0.0.1:8000 -t build
```

The checker verifies required API/guide pages, all local href/src targets with
HTML base semantics, output size (32 MiB), regular files, and absence of common
private-file/diagnostic/token patterns. These are bounded smoke checks, not a
claim that an arbitrary secret is detectable. Review source content before merging.
The docs builder keeps tool diagnostics out of public HTML buffers.

The Build Docs workflow validates PRs without deploying. Default-branch docs/source
pushes and manual default-branch dispatches generate and validate the site, retain
one artifact for one day, then publish that same artifact. Builds use read-only
repository permissions; only the default-branch publish job receives Contents
write (for `gh-pages`), Pages write and the OIDC token used by `deploy-pages`.
Jobs use standard public Ubuntu runners, timeouts, no schedule or paid service.

The `gh-pages` branch contains generated files. `CNAME`, if present, is preserved;
do not add unrelated content to a generated branch. No custom domain is configured
by this change. GitHub-token pushes alone do not trigger branch-based Pages builds,
so the workflow also uses GitHub's Pages artifact deployment explicitly. Configure
the repository's Pages publishing source as **GitHub Actions**. The Pages settings
and `github-pages` environment are separate from any YouTube upload environment;
this workflow never accesses Google credentials or changes upload gates.

Before calling the site live, verify the deployment's source revision, successful
publish job, configured Pages URL and anonymous responses for the landing page,
API reference, uploader guide and case study. Source generation alone is not a
live deployment. The default address is
`https://valgorithms.github.io/YoutubePHP/`.

References: [phpDocumentor configuration](https://docs.phpdoc.org/guide/references/configuration.html),
[custom Pages workflows](https://docs.github.com/en/pages/getting-started-with-github-pages/using-custom-workflows-with-github-pages),
[Pages publishing source](https://docs.github.com/en/pages/getting-started-with-github-pages/configuring-a-publishing-source-for-your-github-pages-site).
