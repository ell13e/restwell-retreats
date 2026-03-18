/*
 * FAQ Page — Restwell Retreats
 * Design: Coastal Calm / Organic Minimalism
 */
import Layout from "@/components/Layout";
import { Link } from "wouter";
import { ArrowRight } from "lucide-react";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";

const faqs = [
  {
    q: "Is this a care home?",
    a: "No. Restwell Retreats is a private holiday let — a real house that you have entirely to yourself. It is not a care home, a residential facility, or a clinical environment. Care is an optional extra that you can choose to add through our partner, Continuity of Care Services. If you don't want care support, you simply enjoy the property as a standard holiday let."
  },
  {
    q: "Can I bring my own carer or PA?",
    a: "Absolutely. Many of our guests bring their own Personal Assistant or carer. The property is designed to accommodate everyone comfortably. You can also use CCS for 'top-up' support alongside your own carer — for example, giving them a few hours off to explore Whitstable while CCS covers."
  },
  {
    q: "What care can you provide, and how is it arranged?",
    a: "Care is provided by Continuity of Care Services (CCS), a CQC-regulated Kent-based provider. Support can range from a brief morning check-in to more comprehensive daily assistance. We will discuss your needs before your stay and arrange the right level of support. There is no fixed package — it is flexible and based on what works for you. PLACEHOLDER – Specific care options and pricing to be confirmed by client."
  },
  {
    q: "What accessibility features does the property have?",
    a: "The property has level access throughout the ground floor and wide doorways suitable for wheelchair access. It is located on a quiet, flat residential street. For full details — including items still being confirmed — please visit our Accessibility page, where we list everything honestly and in detail."
  },
  {
    q: "How do I book?",
    a: "Start by using our enquiry form or getting in touch by phone or email. We will talk through your dates, your needs, and any questions you have. This is just the start of a conversation, not a commitment. Once we have confirmed availability and you are happy with everything, we will confirm your booking. PLACEHOLDER – Specific booking process and deposit details to be confirmed by client."
  },
  {
    q: "What if my care needs change during my stay?",
    a: "Because we work with CCS — a local, established care provider — we can often be flexible. If your needs change during your stay, let us know as soon as possible and we will do our best to adjust the support. This is one of the advantages of having an integrated care partner rather than relying on external agencies."
  },
  {
    q: "Is Restwell Retreats regulated? Who provides the care?",
    a: "Restwell Retreats is the holiday brand — we manage the property and your booking. All care is provided by Continuity of Care Services (CCS), which is registered with the Care Quality Commission (CQC). This means their services are independently inspected and regulated for quality and safety. PLACEHOLDER – Link to CQC profile to be confirmed by client."
  },
  {
    q: "What is Whitstable like as a destination?",
    a: "Whitstable is a charming coastal town in Kent, famous for its oysters, independent shops, and relaxed atmosphere. Harbour Street is the heart of the town — a lovely strip of boutiques, galleries, and cafes. The seafront promenade is excellent for walks, and there are plenty of good restaurants. It has an authentic, unhurried feel that makes it perfect for a genuine break."
  },
  {
    q: "Is the beach accessible?",
    a: "We want to be honest: Whitstable's beach is shingle, which is generally not wheelchair-friendly. The stones are loose and uneven. However, the Tankerton Slopes promenade — a long, flat concrete walkway above the beach — is excellent for wheelchair users and offers stunning sea views. There are also accessible cafes and restaurants at street level along the seafront."
  },
  {
    q: "Is there parking at the property?",
    a: "PLACEHOLDER – Parking arrangements (driveway, street parking, blue badge space) to be confirmed by client. We will provide full parking details once confirmed."
  },
  {
    q: "Can I hire mobility equipment locally?",
    a: "PLACEHOLDER – Information about local mobility equipment hire services to be confirmed. We are researching local options and will update this section."
  },
  {
    q: "What is the cancellation policy?",
    a: "PLACEHOLDER – Cancellation policy and terms to be confirmed by client. We will publish clear cancellation terms once they are finalised."
  },
];

export default function FAQ() {
  return (
    <Layout>
      {/* Header */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            Frequently asked questions
          </span>
          <h1 className="text-4xl md:text-5xl mb-6">Questions we get asked</h1>
          <p className="text-[#3a5a63] text-lg leading-relaxed">
            We have tried to cover the most common questions below. If yours isn't here, please don't hesitate to get in touch — we are always happy to talk things through.
          </p>
        </div>
      </section>

      {/* FAQ Accordion */}
      <section className="py-16 md:py-24">
        <div className="container max-w-3xl">
          <Accordion type="single" collapsible className="space-y-3">
            {faqs.map((faq, i) => (
              <AccordionItem
                key={i}
                value={`faq-${i}`}
                className="bg-white rounded-2xl px-8 border-none shadow-sm"
              >
                <AccordionTrigger className="text-left text-[#1B4D5C] font-medium text-lg py-6 hover:no-underline [&>svg]:text-[#D4A853]">
                  {faq.q}
                </AccordionTrigger>
                <AccordionContent className="text-[#3a5a63] text-base leading-relaxed pb-6">
                  {faq.a}
                </AccordionContent>
              </AccordionItem>
            ))}
          </Accordion>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-white text-center">
        <div className="container">
          <h2 className="text-3xl mb-4">Still have a question?</h2>
          <p className="text-[#3a5a63] text-lg mb-8 max-w-md mx-auto">
            We are here to help. No question is too small or too specific.
          </p>
          <Link
            href="/contact"
            className="inline-flex items-center gap-2 bg-[#1B4D5C] text-white font-semibold px-8 py-3 rounded-full hover:bg-[#164350] transition-colors duration-300 no-underline"
          >
            Ask us <ArrowRight size={18} />
          </Link>
        </div>
      </section>
    </Layout>
  );
}
