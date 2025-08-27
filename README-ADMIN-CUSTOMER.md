# Admin & Member Pack (Laravel 10+)

This is a drop-in feature pack implementing:

- Admin registration + email verification (`/admin/register`)
- Admin login/logout (`/admin/login`), blocking unverified
- Admin manage Admins (list/search/create/edit/CSV) (`/admin/member...`)
- Admin manage Members (list/search/create/edit/CSV) (`/admin/customer...`)
- Front (Member) login/logout (`/login`), blocking unverified
- Front member registration + email verification (`/entry`)
- My Page edit for member (`/mypage/edit`)

## Install

1. Create a fresh Laravel app (PHP 8.1+, Laravel 10+).  
   ```bash
   composer create-project laravel/laravel sample
   cd sample
   ```

2. Copy the contents of this zip **into your project root**, merging folders.

3. Ensure `config/auth.php` matches the included file (admin guard + providers).

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Configure mail (for email verification) in `.env`:
   ```env
   MAIL_MAILER=log  # for local dev
   # or use smtp details
   ```

6. Serve:
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
