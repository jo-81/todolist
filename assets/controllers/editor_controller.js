import { Controller } from "@hotwired/stimulus";
import { getComponent } from "@symfony/ux-live-component";

import {
	ClassicEditor,
	Autoformat,
	Autosave,
	BalloonToolbar,
	BlockQuote,
	Bold,
	Code,
	CodeBlock,
	Essentials,
	FontColor,
	FontSize,
	Heading,
	HorizontalLine,
	Indent,
	IndentBlock,
	Italic,
	Link,
	List,
	ListProperties,
	Paragraph,
	Strikethrough,
	TextTransformation,
	TodoList,
	Underline
} from '../ckeditor/ckeditor5.js';

import translations from "../ckeditor/translations/fr.js";
/*
 * The following line makes this controller "lazy": it won't be downloaded until needed
 * See https://github.com/symfony/stimulus-bridge#lazy-controllers
 */
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    editor = null;

    static targets = ["contentEditor"];

    async initialize() {
        this.component = await getComponent(this.element);
        this.setupEditor();
    }

    setupEditor() {
        this.component.on('render:finished', () => {
            if (this.editor) {
                this.editor.destroy().then(() => {
                    this.editor = null;
                });
            }

            if (!this.hasContentEditorTarget) return;
            ClassicEditor.create(this.contentEditorTarget, this.getEditorConfig())
                .then(editor => {
                    this.editor = editor;
                        editor.model.document.on('change:data', () => {
                            this.contentEditorTarget.value = this.editor.getData();
                            this.contentEditorTarget.dispatchEvent(new Event("change", { bubbles: true }));
                        });
                    })
                    .catch(error => {
                        console.error('CKEditor error:', error);
                    });
        });
    }

    getEditorConfig() {
        return { 
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'fontSize',
                    'fontColor',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    'code',
                    '|',
                    'horizontalLine',
                    'link',
                    'blockQuote',
                    'codeBlock',
                    '|',
                    'bulletedList',
                    'numberedList',
                    'todoList',
                    'outdent',
                    'indent'
                ],
                shouldNotGroupWhenFull: false
            },
            plugins: [
                Autoformat,
                Autosave,
                BalloonToolbar,
                BlockQuote,
                Bold,
                Code,
                CodeBlock,
                Essentials,
                FontColor,
                FontSize,
                Heading,
                HorizontalLine,
                Indent,
                IndentBlock,
                Italic,
                Link,
                List,
                ListProperties,
                Paragraph,
                Strikethrough,
                TextTransformation,
                TodoList,
                Underline
            ],
            balloonToolbar: ['bold', 'italic', '|', 'link', '|', 'bulletedList', 'numberedList'],
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            heading: {
                options: [
                    {
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            link: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                decorators: {
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            menuBar: {
                isVisible: true
            },
            language: 'fr',
            licenseKey: 'GPL',
            translations: [translations]
        };
    }

    disconnect() {
        if (this.editor) {
            this.editor.destroy();
        }
    }
}
