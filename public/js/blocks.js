(function () {

    'use strict';

    window._wpLoadBlockEditor.then(function () {
        var embedVariations = wp.blocks.getBlockVariations('core/embed');

        if (!Array.isArray(embedVariations)) {
            return;
        }

        embedVariations.forEach(function (variation) {
            if (innocodeNormalizeAllowedEmbedBlockVariations.indexOf(variation.name) !== -1) {
                return;
            }

            wp.blocks.unregisterBlockVariation('core/embed', variation.name);
        });
    });
})();