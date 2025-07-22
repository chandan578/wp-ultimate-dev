wp.blocks.registerBlockType("ourblocktheme/header", {
  title: "Fictional University Header",

  edit: function(){
    return wp.element.createElement('div', {className: "our-placeholder-block"}, "Header ")
  },
  save: function(){
    return null;
  }
})