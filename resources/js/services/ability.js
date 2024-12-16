import { defineAbility } from "@casl/ability";

export const ability = defineAbility((can,cannot) => {
    can("read", "public");
});

export function updateAbility(permissions) {
    const newAbility = defineAbility((can,cannot)=>{
        permissions.forEach(permission => {
            const [action,subject] = permission.split("-");
            can(action,subject);
        });
    })
    ability.update(newAbility.rules);
}

export default ability;
