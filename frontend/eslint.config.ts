import pluginVitest from '@vitest/eslint-plugin'
import {defineConfigWithVueTs, vueTsConfigs} from '@vue/eslint-config-typescript'
import pluginImport from 'eslint-plugin-import'
import pluginVue from 'eslint-plugin-vue'

// import skipFormatting from '@vue/eslint-config-prettier/skip-formatting'

// To allow more languages other than `ts` in `.vue` files, uncomment the following lines:
// import { configureVueProject } from '@vue/eslint-config-typescript'
// configureVueProject({ scriptLangs: ['ts', 'tsx'] })
// More info at https://github.com/vuejs/eslint-config-typescript/#advanced-setup

export default defineConfigWithVueTs(
  {
    name: 'app/files-to-lint',
    files: ['**/*.{ts,mts,tsx,vue}'],
  },

  {
    name: 'app/files-to-ignore',
    ignores: ['**/dist/**', '**/dist-ssr/**', '**/coverage/**'],
  },

  ...pluginVue.configs['flat/recommended'],
  vueTsConfigs.recommended,

  {
    ...pluginVitest.configs.recommended,
    files: ['src/**/__tests__/*'],
  },
  // skipFormatting,
  {
    plugins: { import: pluginImport },
    rules: {
      // "sort-imports": ["error", {
      //   "ignoreCase": false,
      //   "ignoreDeclarationSort": false,
      //   "ignoreMemberSort": false,
      //   "memberSyntaxSortOrder": ["none", "all", "multiple", "single"],
      //   "allowSeparatedGroups": false,
      // }],
      "import/order": ["error", {
        "groups": ["builtin", "external", "internal", "parent", "sibling", "index"],
        "newlines-between": "always",
        "alphabetize": {"order": "asc", "caseInsensitive": true}
      }]
    }
  },
)
