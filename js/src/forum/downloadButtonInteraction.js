import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import Post from 'flarum/forum/components/Post';

/* global $ */

export default function () {
  extend(Post.prototype, 'oncreate', function () {
    this.$('[data-hiepvq-upload-download-uuid]')
      .unbind('click')
      .on('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        if (!app.forum.attribute('hiepvq-upload.canDownload')) {
          alert(app.translator.trans('hiepvq-upload.forum.states.unauthorized'));
          return;
        }

        let url = app.forum.attribute('apiUrl') + '/hiepvq/download';

        url += '/' + encodeURIComponent(e.currentTarget.dataset.hiepvqUploadDownloadUuid);
        url += '/' + encodeURIComponent(this.attrs.post.id());
        url += '/' + encodeURIComponent(app.session.csrfToken);

        window.open(url);
      });
  });
}
