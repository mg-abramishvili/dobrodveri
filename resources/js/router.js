import { createRouter, createWebHistory } from 'vue-router'

import Home from './components/admin/Home.vue'

import Products from './components/admin/products/Index.vue'
import DeactivatedProducts from './components/admin/products/IndexDeactivated.vue'
import ProductMaster from './components/admin/products/Master.vue'

import Categories from './components/admin/categories/Index.vue'
import CategoryMaster from './components/admin/categories/Master.vue'

import Colors from './components/admin/colors/Index.vue'
import ColorMaster from './components/admin/colors/Master.vue'

import Styles from './components/admin/styles/Index.vue'
import StyleMaster from './components/admin/styles/Master.vue'

import Factories from './components/admin/factories/Index.vue'
import FactoryMaster from './components/admin/factories/Master.vue'

import Constructs from './components/admin/constructs/Index.vue'
import ConstructMaster from './components/admin/constructs/Master.vue'

import Surfaces from './components/admin/surfaces/Index.vue'
import SurfaceMaster from './components/admin/surfaces/Master.vue'

import Types from './components/admin/types/Index.vue'
import TypeMaster from './components/admin/types/Master.vue'

import Purposes from './components/admin/purposes/Index.vue'
import PurposeMaster from './components/admin/purposes/Master.vue'

import InnerDecors from './components/admin/innerdecors/Index.vue'
import InnerDecorMaster from './components/admin/innerdecors/Master.vue'

import FurnitureTypes from './components/admin/furnituretypes/Index.vue'
import FurnitureTypeMaster from './components/admin/furnituretypes/Master.vue'

import Glasses from './components/admin/glasses/Index.vue'
import GlassMaster from './components/admin/glasses/Master.vue'

import MainSlider from './components/admin/mainslider/Index.vue'
import MainSlideMaster from './components/admin/mainslider/Master.vue'

import Leads from './components/admin/leads/Index.vue'
import Lead from './components/admin/leads/Lead.vue'

import Reviews from './components/admin/reviews/Index.vue'

import Pages from './components/admin/pages/Index.vue'
import PageMaster from './components/admin/pages/Master.vue'

const routes = [
    {
        path: '/admin',
        name: 'Home',
        component: Home
    },
    {
        path: '/admin/products',
        name: 'Products',
        component: Products
    },
    {
        path: '/admin/deactivated-products',
        name: 'DeactivatedProducts',
        component: DeactivatedProducts
    },
    {
        path: '/admin/product-master/:id?',
        name: 'ProductMaster',
        component: ProductMaster
    },
    {
        path: '/admin/categories',
        name: 'Categories',
        component: Categories
    },
    {
        path: '/admin/category-master/:id?',
        name: 'CategoryMaster',
        component: CategoryMaster
    },
    {
        path: '/admin/colors',
        name: 'Colors',
        component: Colors
    },
    {
        path: '/admin/color-master/:id?',
        name: 'ColorMaster',
        component: ColorMaster
    },
    {
        path: '/admin/styles',
        name: 'Styles',
        component: Styles
    },
    {
        path: '/admin/style-master/:id?',
        name: 'StyleMaster',
        component: StyleMaster
    },
    {
        path: '/admin/factories',
        name: 'Factories',
        component: Factories
    },
    {
        path: '/admin/factory-master/:id?',
        name: 'FactoryMaster',
        component: FactoryMaster
    },
    {
        path: '/admin/constructs',
        name: 'Constructs',
        component: Constructs
    },
    {
        path: '/admin/construct-master/:id?',
        name: 'ConstructMaster',
        component: ConstructMaster
    },
    {
        path: '/admin/surfaces',
        name: 'Surfaces',
        component: Surfaces
    },
    {
        path: '/admin/surface-master/:id?',
        name: 'SurfaceMaster',
        component: SurfaceMaster
    },
    {
        path: '/admin/types',
        name: 'Types',
        component: Types
    },
    {
        path: '/admin/type-master/:id?',
        name: 'TypeMaster',
        component: TypeMaster
    },
    {
        path: '/admin/purposes',
        name: 'Purposes',
        component: Purposes
    },
    {
        path: '/admin/purpose-master/:id?',
        name: 'PurposeMaster',
        component: PurposeMaster
    },
    {
        path: '/admin/innerdecors',
        name: 'InnerDecors',
        component: InnerDecors
    },
    {
        path: '/admin/innerdecor-master/:id?',
        name: 'InnerDecorMaster',
        component: InnerDecorMaster
    },
    {
        path: '/admin/furnituretypes',
        name: 'FurnitureTypes',
        component: FurnitureTypes
    },
    {
        path: '/admin/furnituretype-master/:id?',
        name: 'FurnitureTypeMaster',
        component: FurnitureTypeMaster
    },
    {
        path: '/admin/glasses',
        name: 'Glasses',
        component: Glasses
    },
    {
        path: '/admin/glass-master/:id?',
        name: 'GlassMaster',
        component: GlassMaster
    },
    {
        path: '/admin/mainslider',
        name: 'MainSlider',
        component: MainSlider
    },
    {
        path: '/admin/mainslide-master/:id?',
        name: 'MainSlideMaster',
        component: MainSlideMaster
    },
    {
        path: '/admin/leads',
        name: 'Leads',
        component: Leads
    },
    {
        path: '/admin/lead/:id',
        name: 'Lead',
        component: Lead
    },
    {
        path: '/admin/reviews',
        name: 'Reviews',
        component: Reviews
    },
    {
        path: '/admin/pages',
        name: 'Pages',
        component: Pages
    },
    {
        path: '/admin/page-master/:id?',
        name: 'PageMaster',
        component: PageMaster
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})