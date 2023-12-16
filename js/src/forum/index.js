import app from 'flarum/forum/app';
import User from 'flarum/common/models/User';
import Model from 'flarum/common/Model';
import downloadButtonInteraction from './downloadButtonInteraction';
import addUploadButton from './addUploadButton';
import addUserPageButton from './addUserPageButton';

export { default as extend } from './extend';
export * from './components';

app.initializers.add('hiepvq-upload', () => {
  // Leaving these here for now.
  // @see ./extend.ts
  User.prototype.viewOthersMediaLibrary = Model.attribute('hiepvq-upload-viewOthersMediaLibrary');
  User.prototype.deleteOthersMediaLibrary = Model.attribute('hiepvq-upload-deleteOthersMediaLibrary');
  User.prototype.uploadCountCurrent = Model.attribute('hiepvq-upload-uploadCountCurrent');
  User.prototype.uploadCountAll = Model.attribute('hiepvq-upload-uploadCountAll');
  User.prototype.uploadSharedFiles = Model.attribute('hiepvq-upload-uploadSharedFiles');
  User.prototype.accessSharedFiles = Model.attribute('hiepvq-upload-accessSharedFiles');

  //app.fileListState = new FileListState();

  addUploadButton();
  downloadButtonInteraction();
  addUserPageButton();
});
