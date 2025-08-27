# Admin & Member Pack (Laravel 8+)

This is a drop-in feature pack implementing:

- Admin registration + email verification (`/admin/register`)
- Admin login/logout (`/admin/login`), blocking unverified
- Admin manage Admins (list/search/create/edit/CSV) (`/admin/member...`)
- Admin manage Members (list/search/create/edit/CSV) (`/admin/customer...`)
- Front (Member) login/logout (`/login`), blocking unverified
- Front member registration + email verification (`/entry`)
- My Page edit for member (`/mypage/edit`)

## Install

1. Clone this repo https://github.com/tahsinasuchi/test-app-email-verification-.git

2. Run migrations:
   ```bash
   php artisan migrate
   ```

3. Configure mail (for email verification) in `.env`:
   ```env
    MAIL_MAILER=
    MAIL_HOST=
    MAIL_PORT=2525
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=
    MAIL_FROM_ADDRESS=
   # or use smtp details
   ```

4. Serve:
   ```bash
   php artisan serve
   ```

## Notes

- Email verification uses Laravel's built-in flow. For Admin verification routes, we provide namespaced routes under `/admin/email/verify...`.
- CSV export uses streamed responses and does not load all rows into memory.
- Simple blade templates are included; style as needed.
- Validation rules cover required/optional and uniqueness. Password is required on create, optional on edit.
- Login uses `login_id` + password; email must be verified to proceed.

## URLs

### Admin
- Register: `/admin/register`
- Login: `/admin/login`
- Admin list: `/admin/member`
- Admin create: `/admin/member/new`
- Admin edit: `/admin/member/{id}/edit`
- Admin CSV: `/admin/member/export/csv`
- Member list: `/admin/customer`
- Member create: `/admin/customer/new`
- Member edit: `/admin/customer/{id}/edit`
- Member CSV: `/admin/customer/export/csv`

### Front (Member)
- Login: `/login`
- Register: `/entry`
- Verify notice: `/email/verify`
- My Page edit: `/mypage/edit`

## Security

- Both Admin and Customer models implement `MustVerifyEmail`.
- Logins fail if `email_verified_at` is null.
- Admin area requires `auth:admin`.

## Customization
- Add fields to migrations and update the `$fillable` properties and form views accordingly.
- Replace simple layouts with your CSS framework of choice.
