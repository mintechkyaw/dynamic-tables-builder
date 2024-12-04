import { defineAbility } from "@casl/ability";

export const ability = defineAbility((can,cannot) => {
    can("read", "public");
});

export function updateAbility(permissions) {
    ability.update((can) => {
        permissions.forEach((permission) => {
            const [action, subject] = permission.split("-");
            can(action, subject);
        });
    });
}

export default ability;
