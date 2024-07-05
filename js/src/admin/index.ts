import app from 'flarum/admin/app';

app.initializers.add('mattoid/flarum-ext-store-auto-check-in', () => {
  app.extensionData.for("mattoid-store-auto-check-in")
    .registerPermission(
      {
        icon: 'fas fa-id-card',
        label: app.translator.trans('mattoid-store-auto-check-in.admin.settings.group-view'),
        permission: 'mattoid-store-auto-check-in.group-view',
        allowGuest: true
      }, 'view')
});
