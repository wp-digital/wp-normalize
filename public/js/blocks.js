(function (disallowedBlockTypes, allowedEmbedBlockVariations) {

    'use strict';

    window._wpLoadBlockEditor.then(function () {
        var blockTypes = wp.blocks.getBlockTypes();

        if (Array.isArray(blockTypes)) {
            blockTypes.filter(function (blockType) {
                return disallowedBlockTypes.indexOf(blockType.name) !== -1;
            }).forEach(function (blockType) {
                wp.blocks.unregisterBlockType(blockType.name);
            });
        }

        var embedVariations = wp.blocks.getBlockVariations('core/embed');

        if (Array.isArray(embedVariations)) {
            embedVariations.filter(function (variation) {
                return allowedEmbedBlockVariations.indexOf(variation.name) === -1;
            }).forEach(function (variation) {
                wp.blocks.unregisterBlockVariation('core/embed', variation.name);
            });
        }
    });
})(window.innocodeNormalizeDisallowedBlockTypes, window.innocodeNormalizeAllowedEmbedBlockVariations);