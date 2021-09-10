import Vue from "vue";
import Home from "../src/views/Home";

describe("Home.test.js", () => {
    let cmp, vm;

    beforeEach(() => {
        cmp = Vue.extend(Home); // Create a copy of the original component
        vm = new cmp({
            data: {
                // Replace data value with this fake data
                issue: 5
            }
        }).$mount(); // Instances and mounts the component
    });

    it('equals messages to ["Cat"]', () => {
        expect(vm.issue).toEqual(5);
    });
});
