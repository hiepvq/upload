import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import TextEditor from 'flarum/common/components/TextEditor';
import UploadButton from './components/UploadButton';
import DragAndDrop from './components/DragAndDrop';
import PasteClipboard from './components/PasteClipboard';
import Uploader from './handler/Uploader';
import FileManagerButton from './components/FileManagerButton';

export default function () {
  extend(TextEditor.prototype, 'oninit', function () {
    this.uploader = new Uploader();
  });
  extend(TextEditor.prototype, 'controlItems', function (items) {
    if (!app.forum.attribute('hiepvq-upload.canUpload')) return;

    const composerButtonVisiblity = app.forum.attribute('hiepvq-upload.composerButtonVisiblity');

    // Add media button
    if (composerButtonVisiblity === 'both' || composerButtonVisiblity === 'media-btn') {
      items.add(
        'hiepvq-upload-media',
        FileManagerButton.component({
          uploader: this.uploader,
        })
      );
    }

    // Add upload button
    if (composerButtonVisiblity === 'both' || composerButtonVisiblity === 'upload-btn') {
      items.add(
        'hiepvq-upload',
        UploadButton.component({
          uploader: this.uploader,
        })
      );
    }
  });

  extend(TextEditor.prototype, 'oncreate', function (f_, vnode) {
    if (!app.forum.attribute('hiepvq-upload.canUpload')) return;

    this.uploader.on('success', ({ file, addBBcode }) => {
      if (!addBBcode) return;

      this.attrs.composer.editor.insertAtCursor(file.bbcode() + '\n', false);

      // We wrap this in a typeof check to prevent it running when a user
      // is creating a new discussion. There's nothing to preview in a new
      // discussion, so the `preview` function isn't defined.
      if (typeof this.attrs.preview === 'function') {
        // Scroll the preview into view
        // preview() causes the composer to close on mobile, but we don't want that. We want only the scroll
        // We work around that by temporarily patching the isFullScreen method
        const originalIsFullScreen = app.composer.isFullScreen;

        app.composer.isFullScreen = () => false;

        this.attrs.preview();

        app.composer.isFullScreen = originalIsFullScreen;
      }
    });

    // Gracefully fail if the TextEditor was used in a non-Composer context
    // Using a custom method to retrieve the target allows other extensions to still use this feature by returning an alternate container
    const dragAndDropTarget = this.hiepvqUploadDragAndDropTarget();

    if (dragAndDropTarget) {
      this.dragAndDrop = new DragAndDrop((files) => this.uploader.upload(files), dragAndDropTarget);
    }

    new PasteClipboard((files) => this.uploader.upload(files), this.$('.TextEditor-editor')[0]);
  });

  extend(TextEditor.prototype, 'onremove', function (f_, vnode) {
    if (!app.forum.attribute('hiepvq-upload.canUpload')) return;

    if (this.dragAndDrop) {
      this.dragAndDrop.unload();
    }
  });

  TextEditor.prototype.hiepvqUploadDragAndDropTarget = function () {
    return this.$().parents('.Composer')[0];
  };
}
