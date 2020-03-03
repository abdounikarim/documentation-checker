### Installation

Clone this repository : 
```bash
git clone https://github.com/abdounikarim/documentation-checker
```

Install composer dependencies : 
```bash
composer install
```

### Usage

To interact with Github API, you need to authenticate with a token. If you don't have one, you can create one here : 
[Github Token][1]

Create a new `env.local` file and add a new `GITHUB_TOKEN` environment variable : 

```env
GITHUB_TOKEN=github_token
```

Don't replace this key on the `.env` file !

[1]: https://github.com/settings/tokens