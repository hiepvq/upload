import app from 'flarum/admin/app';
import UploadPage from './components/UploadPage';

export * from './components';

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
    );
});
