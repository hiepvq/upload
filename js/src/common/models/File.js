import Model from 'flarum/common/Model';
import mixin from 'flarum/common/utils/mixin';

export default class File extends mixin(Model, {
  baseName: Model.attribute('baseName'),
  path: Model.attribute('path'),
  url: Model.attribute('url'),
  type: Model.attribute('type'),
  size: Model.attribute('size'),
  humanSize: Model.attribute('humanSize'),
  createdAt: Model.attribute('createdAt'),
  uuid: Model.attribute('uuid'),
  tag: Model.attribute('tag'),
  hidden: Model.attribute('hidden'),
  bbcode: Model.attribute('bbcode'),
}) {
  /**
   * Use Hiepvq Uploads endpoint
   */
  apiEndpoint() {
    return '/hiepvq/uploads' + (this.exists ? '/' + this.data.id : '');
  }
}
