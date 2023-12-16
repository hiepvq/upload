import User from 'flarum/common/models/User';
import { default as extend } from '../common/extend';
import Extend from 'flarum/common/extenders';
import UploadsUserPage from './components/UploadsUserPage';

export default [
  ...extend,

  // Not using the new extender yet, thinking about if to change the serialized names,
  // or the js property names, as we can't change the key->attribute name via the extender,
  // like we used to do with ie `User.prototype.viewOthersMediaLibrary = Model.attribute('hiepvq-upload-viewOthersMediaLibrary');`
  // new Extend.Model(User) //
  //     .attribute<boolean>('hiepvq-upload-viewOthersMediaLibrary')
  //     .attribute<boolean>('hiepvq-upload-deleteOthersMediaLibrary')
  //     .attribute<number>('hiepvq-upload-uploadCountCurrent')
  //     .attribute<number>('hiepvq-upload-uploadCountAll'),

  new Extend.Routes() //
    .add('user.uploads', '/u/:username/uploads', UploadsUserPage),
];
