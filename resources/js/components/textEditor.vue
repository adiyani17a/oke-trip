<template>
  <div>
    <!--Use the component in the right place of the template-->
    <h1>Term & Condition</h1>
    <hr>
    <tiptap-vuetify
      v-model="content"
      :extensions="extensions"
    />

    <!--Here's how to make a preview (optional)-->
  </div>
</template>

<script>
// import the component and the necessary extensions
import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, CodeBlock, Paragraph, BulletList, OrderedList,
  ListItem, Link, Blockquote, HardBreak, HorizontalRule, History
} from 'tiptap-vuetify'

export default {
    // specify in the list of components
    components: {
        TiptapVuetify
    },
    data: () => ({
        // declare extensions you want to use
        extensions: [
            // you can specify options for extension
            new Heading({
                levels: [1, 2, 3]
            }),
            new Bold(),
            new Italic(),
            new Strike(),
            new Underline(),
            new Code(),
            new CodeBlock(),
            new Paragraph(),
            new BulletList(),
            new OrderedList(),
            new ListItem(),
            new Link(),
            new Blockquote(),
            new HardBreak(),
            new HorizontalRule(),
            new History()
        ],
        // starting content for the editor
        content: `<h1>Yay Headlines!</h1>
            <p>All these <strong>cool tags</strong> are working now.</p>`
    }),
    watch: {
        content: function() {
          this.$emit('textContent', this.content)
        }
    },
}
</script>