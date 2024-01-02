import app from 'flarum/admin/app';
import UploadPage from './components/UploadPage';
import extendAdminNav from './extendAdminNav';
import FileListState from '../common/states/FileListState';

export * from './components';

export { default as extend } from './extend';

app.initializers.add('hiepvq-upload', () => {
  app.extensionData
    .for('hiepvq-upload')
    .registerPage(UploadPage)
    .registerPermission(
      {
        icon: 'far fa-file',
        label: app.translator.trans('hiepvq-upload.admin.permissions.upload_label'),
        permission: 'hiepvq-upload.upload',
      },
      'start',
      50
    )
    .registerPermission(
      {
        icon: 'fas fa-download',
        label: app.translator.trans('hiepvq-upload.admin.permissions.download_label'),
        permission: 'hiepvq-upload.download',
        allowGuest: true,
      },
      'view',
      50
    )
    .registerPermission(
      {
        icon: 'fas fa-eye',
        label: app.translator.trans('hiepvq-upload.admin.permissions.view_user_uploads_label'),
        permission: 'hiepvq-upload.viewUserUploads',
      },
      'moderate',
      50
    )
    .registerPermission(
      {
        icon: 'fas fa-trash',
        label: app.translator.trans('hiepvq-upload.admin.permissions.delete_uploads_of_others_label'),
        permission: 'hiepvq-upload.deleteUserUploads',
      },
      'moderate',
      50
    )
    .registerPermission(
      {
        icon: 'far fa-file-alt',
        label: app.translator.trans('hiepvq-upload.admin.permissions.upload_shared_label'),
        permission: 'hiepvq-upload.upload-shared-files',
      },
      'start'
    )
    .registerPermission(
      {
        icon: 'far fa-file-alt',
        label: app.translator.trans('hiepvq-upload.admin.permissions.access_shared_label'),
        permission: 'hiepvq-upload.access-shared-files',
      },
      'start'
    );

  extendAdminNav();

  //app.fileListState = new FileListState();
});
