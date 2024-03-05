/* eslint-env node */
require("@rushstack/eslint-patch/modern-module-resolution")

module.exports = {
    root: true,
    ignorePatterns: ["/auto-imports.d.ts", "/components.d.ts"],
    extends: ["plugin:vue/vue3-essential", "eslint:recommended", "@vue/eslint-config-typescript/recommended", "@vue/eslint-config-prettier", "./.eslintrc-auto-import.json"],
    rules: {
        "prettier/prettier": [
            "error",
            {
                semi: false,
                singleQuote: false,
                proseWrap: "preserve",
                endOfLine: "lf",
                tabWidth: 4,
                useTabs: false,
                trailingComma: "none"
            }
        ],
        "vue/multi-word-component-names": "off",
        "@typescript-eslint/no-explicit-any": "off",
        "@typescript-eslint/ban-ts-comment": "off",
        "no-undef": "off",
        "vue/prefer-import-from-vue": "off",
        "no-prototype-builtins": "off",
        "prefer-spread": "off",
        "@typescript-eslint/no-non-null-assertion": "off",
        "@typescript-eslint/no-non-null-asserted-optional-chain": "off",
        "no-useless-escape": "off",
        "vue/no-mutating-props": "off",
        "@typescript-eslint/no-unused-vars": "off"
    },
    globals: {
        module: "readonly"
    }
}
